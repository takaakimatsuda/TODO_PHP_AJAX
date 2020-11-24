$(function() {
  'use strict';

  $('#new_todo').focus();

  // delete
  $('#todos').on('click', '.delete_todo', function() {
    // idを取得
    const id = $(this).parents('li').data('id');
    // ajax処理
    $.post('_ajax.php', {
      id: id,
      mode: 'delete',
      // ビューのトークンの値を送信
      token: $('#token').val()
    }, function() {
      $('#todo_' + id).fadeOut(800);
    });
  });

  // create
  $('#new_todo_form').on('submit', function() {
    // titleを取得
    const title = $('#new_todo').val();
    // ajax処理
    $.post('_ajax.php', {
      title: title,
      mode: 'create',
      token: $('#token').val()
    }, function(res) {
      // liを追加
      const $li = $('#todo_template').clone();
      $li
        .attr('id', 'todo_' + res.id)
        .data('id', res.id)
        .find('.todo_title').text(title);
      $('#todos').prepend($li.fadeIn());
      $('#new_todo').val('').focus();
    });
    return false;
  });
  
});