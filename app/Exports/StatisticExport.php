<?php

namespace App\Exports;

use App\DTO\Statistics\ExportDTO;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StatisticExport implements FromCollection, Responsable, ShouldAutoSize, WithEvents, WithHeadings
{
    use Exportable;

    private $fileName = 'statistics_report.xlsx';

    public function __construct(
        protected ExportDTO $dto
    ) {}

    public function collection(): Collection
    {
        $users = User::role('employee')->where('id', '<>', auth()->id());

        $subQueryYear = "";
        $subQueryMonth = "";

        if ($this->dto->year) {
            $subQueryYear = "
                AND EXTRACT(YEAR FROM table.created_at) = {$this->dto->year}
            ";
        }

        if ($this->dto->month) {
            $subQueryMonth = "
                AND EXTRACT(MONTH FROM table.created_at) = {$this->dto->month}
            ";
        }

        $users->select([
            DB::raw("
                ROW_NUMBER() OVER (
                    ORDER BY id
                ) as row_num
            "),
            'name',
            // выполненные задачи
            DB::raw("
                (
                    SELECT
                        CAST(COUNT(tasks.*) AS varchar)
                    FROM
                        tasks
                    JOIN task_user ON task_user.task_id = tasks.id
                    WHERE
                        users.id = task_user.user_id
                        AND tasks.status = 'completed'
                        AND tasks.extended_deadline IS NULL
                        " . str_replace('table', 'tasks', $subQueryYear) . "
                        " . str_replace('table', 'tasks', $subQueryMonth) . "
                ) as completed_on_time
            "),
            DB::raw("
                (
                    SELECT
                        CAST(COUNT(tasks.*) AS varchar)
                    FROM
                        tasks
                    JOIN task_user ON task_user.task_id = tasks.id
                    WHERE
                        users.id = task_user.user_id
                        AND tasks.status = 'completed'
                        AND tasks.extended_deadline IS NOT NULL
                        " . str_replace('table', 'tasks', $subQueryYear) . "
                        " . str_replace('table', 'tasks', $subQueryMonth) . "
                ) as completed_expired
            "),
            // не выполненные задачи
            DB::raw("
                (
                    SELECT
                        CAST(COUNT(tasks.*) AS varchar)
                    FROM
                        tasks
                    JOIN task_user ON task_user.task_id = tasks.id
                    WHERE
                        users.id = task_user.user_id
                        AND tasks.status IN ('new', 'in_progress', 'pending', 'correction')
                        AND COALESCE(extended_deadline, deadline) >= NOW()
                        " . str_replace('table', 'tasks', $subQueryYear) . "
                        " . str_replace('table', 'tasks', $subQueryMonth) . "
                ) as unfulfilled_active
            "),
            DB::raw("
                (
                    SELECT
                        CAST(COUNT(tasks.*) AS varchar)
                    FROM
                        tasks
                    JOIN task_user ON task_user.task_id = tasks.id
                    WHERE
                        users.id = task_user.user_id
                        AND tasks.status IN ('new', 'in_progress', 'pending', 'extend', 'correction')
                        AND COALESCE(extended_deadline, deadline) <= NOW()
                        " . str_replace('table', 'tasks', $subQueryYear) . "
                        " . str_replace('table', 'tasks', $subQueryMonth) . "
                ) as unfulfilled_expired
            "),
            // баллы
            DB::raw("
                (
                    SELECT
                        CAST(COALESCE(SUM(point), 0) AS varchar)
                    FROM
                        user_points
                    WHERE
                        users.id = user_points.employee_id
                        " . str_replace('table', 'user_points', $subQueryYear) . "
                        " . str_replace('table', 'user_points', $subQueryMonth) . "
                ) as points
            "),
        ]);

        if ($this->dto->employeesIds) {
            $users->whereIn('id', $this->dto->employeesIds);
        }

        $users->orderByDesc('points');
        
        return $users->get();
    }

    public function headings(): array
    {
        return [
            [
                '№',
                'Ф.И.О',
                'Исполнено',
                '',
                'Не исполнено',
                '',
                'Баллы',
            ],
            [
                '',
                '',
                'В срок',
                'Вне срока',
                'Активные',
                'Просроченные',
                '',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastColumn = $event->sheet->getHighestColumn();
                $lastRow = $event->sheet->getHighestRow();
                $range = 'A1:' . $lastColumn . $lastRow;

                $event->sheet->setMergeCells([
                    'A1:A2',
                    'B1:B2',
                    'C1:D1',
                    'E1:F1',
                    'G1:G2',
                ]);

                $event->sheet->getStyle('A1:' . $lastColumn . '1')->getFont()->setBold(true);
                $event->sheet->getStyle('A2:' . $lastColumn . '2')->getFont()->setBold(true);

                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '#000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
            },
        ];
    }
}
