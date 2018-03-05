// Lazy-load WordPress gallery images
var elements = document.querySelectorAll('.lazy-img');
var gallery_images = document.querySelectorAll('[data-src]');
var config = {
  rootMargin: '0px 0px 50px 0px',
  threshold: 0
};

var loaded = 0;

// If intersection observer is not supported (IE), load images immediately
if (!('IntersectionObserver' in window)) {
  for (var i = 0; i < elements.length; i++) {
    preloadImage(elements[i]);
  }
} else {
  // If intersection observer is supported
  var observer = new IntersectionObserver(function (entries, self) {
    entries.forEach(function(entry){
      if (entry.isIntersecting) {
        preloadImage(entry.target);
        // Stop watching and load the image
        self.unobserve(entry.target);
      }
    });
  }, config);

  gallery_images.forEach(function(image) {
    observer.observe(image);
  });
}

function preloadImage(img) {
  var src = img.getAttribute('data-src');
  if (!src) { return; }
  img.src = src;
}
