define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'ticket/index' + location.search,
                    add_url: 'ticket/add',
                    edit_url: 'ticket/edit',
                    del_url: 'ticket/del',
                    multi_url: 'ticket/multi',
                    table: 'booth_ticket',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'topic_id', title: __('Topic_id')},
                        {field: 'exhibition_id', title: __('Exhibition_id')},
                        {field: 'ticket_qr_code_url_img', title: __('Ticket_qr_code_url_img')},
                        {field: 'ticket_desc', title: __('Ticket_desc')},
                        {field: 'type', title: __('Type')},
                        {field: 'status', title: __('Status')},
                        {field: 'apply_time', title: __('Apply_time')},
                        {field: 'enable_time', title: __('Enable_time')},
                        {field: 'views', title: __('Views')},
                        {field: 'address', title: __('Address')},
                        {field: 'ticket_fee', title: __('Ticket_fee'), operate:'BETWEEN'},
                        {field: 'ticket_name', title: __('Ticket_name')},
                        {field: 'ticket_img', title: __('Ticket_img')},
                        {field: 'free_money', title: __('Free_money'), operate:'BETWEEN'},
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