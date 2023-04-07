var uploadfiles_2 = document.querySelector('#licence_piture');
uploadfiles_2.addEventListener('change', function () { 
    var files = this.files;
    for(var i=0; i<files.length; i++){
        previewImage_2(this.files[i]);
    }
}, false);

function previewImage_2(file) {
    var galleryId = "pictures_2";
var gallery = document.getElementById(galleryId);
 var imageType = /image.*/;
 if (!file.type.match(imageType)) {
 throw "File Type must be an image";
    }
    var thumb = document.createElement("div");
    thumb.classList.add('thumbnail'); // Add the class thumbnail to the created div
    var img = document.createElement("img");
    img.file = file;
    thumb.appendChild(img);
    gallery.appendChild(thumb);
 
    // Using FileReader to display the image content
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
}
