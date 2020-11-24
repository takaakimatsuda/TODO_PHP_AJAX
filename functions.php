<?php
// 特殊文字をHTMLエンティティに変換する
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}