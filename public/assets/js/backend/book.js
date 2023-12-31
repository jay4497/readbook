define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'book/index' + location.search,
                    add_url: 'book/add',
                    edit_url: 'book/edit',
                    del_url: 'book/del',
                    multi_url: 'book/multi',
                    import_url: 'book/import',
                    table: 'book',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                fixedColumns: true,
                fixedRightNumber: 1,
                search: false,
                showExport: false,
                showToggle: false,
                showColumns: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'cover', title: __('Cover'), formatter: Table.api.formatter.image, operate: false},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'author', title: __('Author'), operate: 'LIKE'},
                        {field: 'publishing', title: __('Publishing'), operate: 'LIKE'},
                        {field: 'published_at', title: __('Published_at'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'status', title: __('Status')},
                        {field: 'weigh', title: __('Weigh'), operate: false},
                        {field: 'created_at', title: __('Created_at'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'updated_at', title: __('Updated_at'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
