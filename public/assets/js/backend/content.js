define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'WangEditor'], function ($, undefined, Backend, Table, Form, Editor) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'content/index' + location.search,
                    add_url: 'content/add',
                    edit_url: 'content/edit',
                    del_url: 'content/del',
                    multi_url: 'content/multi',
                    import_url: 'content/import',
                    table: 'content',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                search: false,
                fixedColumns: true,
                fixedRightNumber: 1,
                showExport: false,
                showToggle: false,
                showColumns: false,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'book_id', title: __('Book_id'), visible: false, addclass: 'selectpage', autocomplete: false, extend: 'data-source="book/index" data-field="title" data-multiple="false"'},
                        {field: 'catalog_id', title: __('Catalog_id'), visible: false, addclass: 'selectpage', autocomplete: false, extend: 'data-source="catalog/index" data-field="title" data-multiple="false"'},
                        {field: 'book_title', title: __('Book_id'), operate: false},
                        {field: 'catalog_title', title: __('Catalog_id'), operate: false},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'views', title: __('Views')},
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
                $('#c-book_id').on('change', (e) => {
                    var val = $(e.target).val();
                    var catalog_el = $('#c-catalog_id_text');
                    if (val) {
                        catalog_el.removeAttr('disabled');
                        catalog_el.removeClass('sp_input_off');
                        catalog_el.data('selectPageObject').option.params = (obj) => {
                            return {
                                custom: {
                                    'book_id': $('#c-book_id').val()
                                }
                            };
                        };
                    } else {
                        catalog_el.attr('disabled', 'disabled');
                    }
                });

                const { createEditor, createToolbar } = Editor;
                var editorContainer = $('.editor');
                editorContainer.hide();
                editorContainer.after('<div class="editor-wrapper"><div class="editor-toolbar"></div><div class="editor-container""></div>');
                var myeditor = createEditor({
                    selector: '.editor-container',
                    html: '<p></p>',
                    config: {
                        placeholder: 'Type here...',
                        onChange(editor) {
                            const html = editor.getHtml();
                            $('#c-content').val(html);
                        }
                    },
                    mode: 'simple', // or 'simple'
                });

                var toolbar = createToolbar({
                    editor: myeditor,
                    selector: '.editor-toolbar',
                    config: {
                        modalAppendToBody: false
                    },
                    mode: 'simple', // or 'simple'
                });

                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
