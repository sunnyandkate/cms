document.addEventListener('DOMContentLoaded', () => {
    const titleInput = document.getElementById('title');
    const slugPreview = document.getElementById('slug-preview');

    if (titleInput && slugPreview) {
        titleInput.addEventListener('input', () => {
            let cleanSlug = titleInput.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Strip symbols
                .replace(/\s+/g, '-')         // Swap spaces for single dashes
                .replace(/-+/g, '-');         // Strip repetitive structural dashes
            
            slugPreview.textContent = cleanSlug || '...';
        });
    }
});


let mobileMenu = document.querySelector(".mobile-menu");
let toggleMenu = document.querySelector(".toggle-menu");

toggleMenu.addEventListener("click", function(){
   
    if (mobileMenu.style.display === "block") {
   		 mobileMenu.style.display = "none";
      } else {
        mobileMenu.style.display = "block";
      }
});
