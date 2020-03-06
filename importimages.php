<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>импорт картинок</title>
</head>
<body>
    <div id="drop-area">
      <form class="my-form">
        <p>картинка должна быть 4к3 что бы не растягивалась</p>
        <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
        <label class="button" for="fileElem">импортировать картинку либо бросьте мышкой сюда</label>
      </form>
        <progress id="progress-bar" max=100 value=0></progress>
      <div id="gallery" /></div>
    </div>
    <style>
body {
  font-family: sans-serif;
}
a {
  color: #369;
}
.note {
  width: 500px;
  margin: 50px auto;
  font-size: 1.1em;
  color: #333;
  text-align: justify;
}
#drop-area {
  border: 2px solid #ccc;
  border-radius: 20px;
  width: 480px;
  margin: 50px auto;
  padding: 20px;
}
#drop-area.highlight {
  border-color: purple;
}
p {
  margin-top: 0;
}
.my-form {
  margin-bottom: 10px;
}
#gallery {
  margin-top: 10px;
}
#gallery img {
  width: 150px;
  margin-bottom: 10px;
  margin-right: 10px;
  vertical-align: middle;
}
.button {
  display: inline-block;
  padding: 10px;
  background: #ccc;
  cursor: pointer;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.button:hover {
  background: #ddd;
}
#fileElem {
  display: none;
}
    </style>
    <script src="draganddrop.js"></script>
</body>
</html>