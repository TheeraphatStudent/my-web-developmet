const reviewImage = (event) => {
    const reader = new FileReader();

    reader.onload = function() {
        const display_img = document.getElementById('avatar_img');
        display_img.src = reader.result;
    };
    
    reader.readAsDataURL(event.target.files[0]);
}