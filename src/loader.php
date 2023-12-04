<div class="h-screen flex justify-center align-middle">
<span class="z-99 loader transition-opacity duration-300 loading loading-dots loading-lg"></span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var loader = document.querySelector('.loader');
        var contentContainer = document.querySelector('.content-container');
        // Show the loader initially
        loader.style.display = 'block';
        contentContainer.style.display = 'none';

        // Trigger reflow to apply initial styles
        loader.offsetHeight;

        setTimeout(function(){
            loader.classList.add('opacity-0');
        }, 1500);

        // Set timeout to hide the loader after 2 seconds
        setTimeout(function(){
            loader.style.display = 'none';
            contentContainer.style.display = 'block';
            loader.parentElement.remove()
        }, 1800);
    });
</script>