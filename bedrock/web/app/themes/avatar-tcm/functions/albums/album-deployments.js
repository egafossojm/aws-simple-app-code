function initAlbumPhotoGalleryDeploy() {
  if (document.querySelectorAll(".album-photo-gallery")) {
    var albumGalleries = document.querySelectorAll(".album-photo-gallery");
    if (albumGalleries) {
      var albumGalleryMoreBtns = document.querySelectorAll(
        ".view-more-album-gallery"
      );
      [...albumGalleryMoreBtns].forEach((button) => {
        button.addEventListener("click", () => {
          toggleAlbumPhotoGallery(button);
        });
      });
    }
  }
}

jQuery(document).ready(function () {
  initAlbumPhotoGalleryDeploy();
});

function toggleAlbumPhotoGallery(button) {
  var albumPhotoGallery = document.querySelector(
    "#" + button.getAttribute("data-href")
  );
  if (albumPhotoGallery) {
    if (albumPhotoGallery.classList.contains("album-deployed")) {
      button.innerHTML =
        'View more <svg style="font-size:10px; margin-left:10px; width:10px; display:inline-block; fill:white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"/></svg>';
    } else {
      button.innerHTML =
        'View less <svg style="font-size:10px; margin-left:10px; width:10px; display:inline-block; fill:white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M240.971 130.524l194.343 194.343c9.373 9.373 9.373 24.569 0 33.941l-22.667 22.667c-9.357 9.357-24.522 9.375-33.901.04L224 227.495 69.255 381.516c-9.379 9.335-24.544 9.317-33.901-.04l-22.667-22.667c-9.373-9.373-9.373-24.569 0-33.941L207.03 130.525c9.372-9.373 24.568-9.373 33.941-.001z"/></svg>';
    }

    albumPhotoGallery.classList.toggle("album-deployed");

    var albumGalleryExtraLinks = albumPhotoGallery.querySelectorAll(
      "a[data-fancybox=gallery]:nth-child(n+17)"
    );
    if (albumGalleryExtraLinks) {
      albumGalleryExtraLinks.forEach((element) => {
        element.classList.toggle("hide");
      });
    }
  }
}
