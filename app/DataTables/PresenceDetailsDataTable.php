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
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('waktu_absen', function ($query) {
                return date('d-m-Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('tanda_tangan', function ($query) {
                return "<img width='100' src='" . asset('uploads/' . $query->tanda_tangan) . "'>";
            })
            ->addColumn('action', function ($query) {
                return "<button type='button' class='btn btn-delete btn-danger' data-url='" . route('presence-detail.destroy', $query->id) . "'>Hapus</button>";
            })
            ->rawColumns(['tanda_tangan', 'action'])
            ->setRowId('id');
    }

    public function query(PresenceDetail $model): QueryBuilder
    {
        return $model->with('presence')->where('presence_id', request()->segment(2))->newQuery();
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
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('No')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(100),
            Column::make('presence.nama_kegiatan')
                ->title('Nama Kegiatan'),
            Column::make('nama'),
            Column::make('np')->title('NP'),
            Column::make('jabatan'),
            Column::make('asal_instansi')->title('Unit Kerja/Instansi'),
            Column::make('tanda_tangan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'PresenceDetails_' . date('YmdHis');
    }
}
