define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'catalog/index' + location.search,
                    add_url: 'catalog/add',
                    edit_url: 'catalog/edit',
                    del_url: 'catalog/del',
                    multi_url: 'catalog/multi',
                    import_url: 'catalog/import',
                    table: 'catalog',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'book_id', title: __('Book_id'), visible: false, addclass: 'selectpage', autocomplete: false, extend: 'data-source="book/index" data-field="title" data-multiple="false"'},
                        {field: 'book_title', title: __('Book_id'), operate: false},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'parent_id', title: __('Parent_id'), visible: false, addclass: 'selectpage', autocomplete:false, extend: 'data-source="catalog/index" data-field="title" data-multiple="false"'},
                        {field: 'parent_title', title: __('Parent_id'), operate: false},
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
                $('#c-book_id').on('change', () => {
                    var val = $(this).val();
                    var catalog_el = $('#c-parent_id');
                    if (val) {
                        catalog_el.removeAttr('disabled');
                        catalog_el.data('params', (obj) => {
                            return {
                                custom: {
                                    'book_id': val
                                }
                            };
                        });
                    } else {
                        catalog_el.attr('disabled', 'disabled');
                    }
                });

                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
