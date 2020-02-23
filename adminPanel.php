<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/admin.css">
  <link rel="stylesheet" href="style/item.css">
  <link rel="stylesheet" href="style/style.css">
  <title>Document</title>
</head>
<body>
<div class="create-card">
    <form>
      <textarea type="pattern" placeholder="описание" class="description-item" rows="0" maxlength="600"></textarea>
      <button type="submit" class="btn btn-submit">создать</button>
      <input type="file" class="one-import file-item">
      <input type="file" class="two-import file-item">
      <input type="file" class="three-import file-item">
      <input type="file" class="four-import file-item">
      <input type="file" class="five-import file-item">
      <input type="file" class="six-import file-item">
      <input type="text" placeholder="название" class="txt-item txt-name">
      <input type="number" placeholder="цена" class="txt-item txt-price">
    </form>
  </div>
  <div class="wrapper">
    <div class="cards" overflow-y:scroll>
        <div class='card-item'>
          <div class='margin-item'>
          <h2 class='item-name'>тест</h2>
          <p class="item-descriprion">
          dssdaasd sadklas dld;jad asdjll;dldjldasjljasdl;djasl
          </p>
          <h3 class="item-price">400р</h3>
          <div class="delete-item">удалить</div>
          <div class="edit-item">редактировать</div>
          </div>
          <div class="owl-carousel owl-theme owl-close item-img">
          <img src="img/oneBB.jpg" class='item-img'>
          <img src="img/twoBB.jpg" class='item-img'>
          <img src="img/threeBB.jpg" class='item-img'>
          <img src="img/fourBB.jpg" class='item-img'>
          <img src="img/fiveBB.jpg" class='item-img'> 
          <img src="img/sixBB.jpg" class='item-img'>
        </div>
      </div>
  </div>
  </div>
  <script src="javascript.js"></script>
</body>
</html>