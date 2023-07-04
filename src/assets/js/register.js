function previewImage(obj) {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
        document.getElementById('img-pre').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
}