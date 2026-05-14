<?php

namespace App\DataTables;

use App\Models\PresenceDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PresenceDetailsDataTable extends DataTable
{
    protected int $presenceId;

    public function setPresenceId(int $presenceId): static
    {
        $this->presenceId = $presenceId;
        return $this;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dt = (new EloquentDataTable($query))
            ->addColumn('waktu_absen', function ($query) {
                return date('d-m-Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('action', function ($query) {
                return "<button type='button' class='btn btn-delete btn-danger' data-url='" . route('presence-detail.destroy', $query->id) . "'>Hapus</button>";
            });

        $presenceId = $this->presenceId ?? request()->integer('presence_id');
        $presence = \App\Models\Presence::find($presenceId);

        $rawColumns = ['action'];

        if ($presence && !empty($presence->custom_fields)) {
            foreach ($presence->custom_fields as $field) {
                $id = $field['id'];
                $dt->addColumn("custom_$id", function ($row) use ($id, $field) {
                    $val = $row->additional_data[$id] ?? '';
                    if ($field['type'] === 'signature' && $val) {
                        return "<img width='100' src='" . asset('uploads/' . $val) . "'>";
                    }
                    return is_array($val) ? implode(', ', $val) : $val;
                });
                
                if ($field['type'] === 'signature') {
                    $rawColumns[] = "custom_$id";
                }
            }
        } else {
            // Legacy
            $dt->addColumn('tanda_tangan', function ($query) {
                if ($query->tanda_tangan) {
                    return "<img width='100' src='" . asset('uploads/' . $query->tanda_tangan) . "'>";
                }
                return '-';
            });
            $rawColumns[] = 'tanda_tangan';
        }

        return $dt->rawColumns($rawColumns)->setRowId('id');
    }

    public function query(PresenceDetail $model): QueryBuilder
    {
        $presenceId = $this->presenceId ?? request()->integer('presence_id');
        return $model->newQuery()->with('presence')->where('presence_id', $presenceId);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('presencedetails-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print')
            ]);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::make('id')->title('No')->render('meta.row + meta.settings._iDisplayStart + 1;')->width(100),
            Column::make('waktu_absen')->title('Waktu')->searchable(false)->orderable(false),
        ];

        $presenceId = $this->presenceId ?? request()->integer('presence_id');
        $presence = \App\Models\Presence::find($presenceId);

        if ($presence && !empty($presence->custom_fields)) {
            foreach ($presence->custom_fields as $field) {
                $columns[] = Column::make("custom_" . $field['id'])
                                ->title($field['label'])
                                ->searchable(false)
                                ->orderable(false);
            }
        } else {
            // Legacy
            $columns[] = Column::make('nama');
            $columns[] = Column::make('np')->title('NP');
            $columns[] = Column::make('jabatan');
            $columns[] = Column::make('asal_instansi')->title('Unit Kerja/Instansi');
            $columns[] = Column::make('tanda_tangan')->searchable(false)->orderable(false);
        }

        $columns[] = Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center');

        return $columns;
    }

    protected function filename(): string
    {
        return 'PresenceDetails_' . date('YmdHis');
    }
}
