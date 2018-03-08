// Lazy-load WordPress gallery images

var gallery_images = document.querySelectorAll('.gallery img');

gallery_images.forEach(function(image) {
  image.classList.add('lazy-img');
});

var images = document.querySelectorAll('.lazy-img');
// var gallery_images = document.querySelectorAll('[data-src]');



var config = {
  root: null, // sets to default, the viewport
  rootMargin: '0px 0px 50px 0px',
  // threshold: 0
  // rootMargin: '0px',
  threshold: 0.5
};

var loaded = 0;

window.addEventListener('load', function(event){
  // If intersection observer is not supported (IE), load images immediately
  if (!('IntersectionObserver' in window)) {
    for (var i = 0; i < images.length; i++) {
      preloadImage(images[i]);
    }
  } else {
    // If intersection observer is supported
    var observer = new IntersectionObserver(function (entries, self) {
      entries.forEach(function(entry){
        if (entry.isIntersecting) {
          // console.log(entry.target);
          preloadImage(entry.target);
          // Stop watching and load the image
          self.unobserve(entry.target);
        }
      });
    }, config);

    images.forEach(function(image) {
      observer.observe(image);
    });
  }

  function preloadImage(img) {
    var src = img.getAttribute('data-src');
    if (!src) {
      return;
    }
    // img.style.animation = 'none';
    img.classList.add('fade-in');
    img.src = src;
  }
}, false);
