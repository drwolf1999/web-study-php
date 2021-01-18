<?php require ("top.php") ?>

<div class="row valign-wrapper right-align">
    <div class="col s10 pull-s1 m6 pull-m3 l4 pull-l4">
        <form>
            <label>
                <input type="radio" name="mode" class="with-gap" checked value="-1" />
                <span>전체</span>
            </label>
            <label>
                <input type="radio" name="mode" class="with-gap" value="1" />
                <span>한 일</span>
            </label>
            <label>
                <input type="radio" name="mode" class="with-gap" value="0" />
                <span>안 끝난 일</span>
            </label>
        </form>
    </div>
</div>

<div id="todo-list"></div>

<div id="todo-add-form">
    <div class="valign-wrapper row">
        <div class="col s10 pull-s1 m6 pull-m3 l4 pull-l4">
            <div class="card darken-1">
                <div class="card-content">
                    <span class="card-title"><input type="text" placeholder="할 일" id="add-title" /></span>
                    <p>
                        <label for="add-description">내용</label>
                        <textarea class="materialize-textarea" placeholder="상세내용" id="add-description"></textarea>
                    </p>
                </div>
                <div class="card-action">
                    <a href="javascript:void(0)" id="reset">초기화</a>
                    <a href="javascript:void(0)" id="add">할 일 추가</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="end-todo-list"></div>

<script type="text/javascript">
    $(document).ready(function () {
        getTodoList();
    });
    function getTodoList() {
        $.ajax({
            url: 'getTodos.php',
            type: 'GET',
            data: {
                'do': MODE(),
            },
            dataType: 'json',
            success: function (data) {
                let title, description, isDo, id;
                const size = data.title.length;
                let todo_list = $('#todo-list');
                let end_todo_list = $('#end-todo-list');
                end_todo_list.empty();
                todo_list.empty();
                let content = '', content_end = '';
                for (let i = 0; i < size; i++) {
                    title = data.title[i];
                    description = data.description[i];
                    isDo = parseInt(data.do[i]);
                    id = parseInt(data.id[i]);
                    let template =
                        `<div class="valign-wrapper row">
                                <div class="col s10 pull-s1 m6 pull-m3 l4 pull-l4">
                                    <div class="card darken-1">
                                        <div class="card-content">
                                            <span class="card-title">${title}</span>
                                            <p>${description}</p>
                                        </div>
                                        <div class="card-action right-align">
                                            <div class="switch">
                                                <label>
                                                    안 함
                                                    <input type="checkbox" ${isDo ? 'checked' : ''} id="${id}-do">
                                                    <span class="lever" onclick="editTodo(${id})"></span>
                                                    함
                                                </label>
                                            </div>
                                        </div>
                                        <input hidden value="${title}" id="${id}-title">
                                        <textarea hidden id="${id}-description">${description}</textarea>
                                    </div>
                                </div>
                            </div>`;
                    if (isDo) {
                        content_end += template;
                    } else {
                        content += template;
                    }
                }
                todo_list.html(content);
                end_todo_list.html(content_end);
            },
            error: function (request, status, error) {
                //
            }
        });
    }

    $('#add').click(function () {
        const title = $('#add-title').val();
        const description = $('#add-description').val();
        $.ajax({
            url: 'addTodo.php',
            type: 'POST',
            data: {
                'title': title,
                'description': description,
            },
            success: function (data) {
                reset();
                getTodoList();
            },
            error: function (request, status, error) {
                console.log(request);
                console.log(error);
            }
        });
    });

    function editTodo(id) {
        const
            title = $(`#${id}-title`).val(),
            description = $(`#${id}-description`).val();
        let isDo = $(`#${id}-do`).is(':checked');
        if (isDo) {
            isDo = 0;
        } else {
            isDo = 1;
        }
        $.ajax({
            url: 'editTodo.php',
            type: 'POST',
            data: {
                'title': title,
                'description': description,
                'do': isDo,
                'id': id
            },
            success: function (data) {
                getTodoList();
            },
            error: function (request, status, error) {
                console.log(request);
                console.log(error);
            }
        });
    }

    function reset() {
        $('#add-title').val('');
        $('#add-description').val('');
    }

    function MODE() {
        return parseInt($('input[name=mode]:checked').val());
    }

    $('input[name=mode]').change(function () {
        let checkedVal = MODE();
        let do_todo_div = $('#todo-list');
        let end_do_todo_div = $('#end-todo-list');
        if (checkedVal === -1) {
            do_todo_div.attr('hidden', false);
            end_do_todo_div.attr('hidden', false);
        } else if (checkedVal === 0) { // undo
            do_todo_div.attr('hidden', false);
            end_do_todo_div.attr('hidden', true);
        } else { // do
            do_todo_div.attr('hidden', true);
            end_do_todo_div.attr('hidden', false);
        }
    });
</script>

<?php require ("bottom.php") ?>