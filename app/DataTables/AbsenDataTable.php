<?php

namespace App\DataTables;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AbsenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dt = new EloquentDataTable($query);
        $rawColumns = [];

        $slug = request()->segment(2);
        $presence = Presence::where('slug', $slug)->first();

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
            // Legacy rendering
            $dt->addColumn('tanda_tangan', function ($row) {
                return "<img width='100' src='" . asset('uploads/' . $row->tanda_tangan) . "'>";
            });
            $rawColumns[] = 'tanda_tangan';
        }

        return $dt->rawColumns($rawColumns)->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PresenceDetail $model): QueryBuilder
    {
        $slug = request()->segment(2);
        $presence = Presence::where('slug', $slug)->first();
        return $model->newQuery()->where('presence_id', $presence->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('absen-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id')
                ->title('No')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(100),
        ];

        $slug = request()->segment(2);
        $presence = Presence::where('slug', $slug)->first();

        if ($presence && !empty($presence->custom_fields)) {
            foreach ($presence->custom_fields as $field) {
                $columns[] = Column::make("custom_" . $field['id'])
                                ->title($field['label'])
                                ->searchable(false)
                                ->orderable(false);
            }
        } else {
            // Legacy columns
            $columns[] = Column::make('nama')->title('Nama');
            $columns[] = Column::make('np')->title('NP');
            $columns[] = Column::make('jabatan')->title('Jabatan');
            $columns[] = Column::make('asal_instansi')->title('Unit Kerja/Instansi');
            $columns[] = Column::make('tanda_tangan')->title('Tanda Tangan')->orderable(false)->searchable(false);
        }

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Absen_' . date('YmdHis');
    }
}
