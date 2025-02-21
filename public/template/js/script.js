// Ham + - so luong san pham
document.querySelectorAll('.increment').forEach(function (button) {
  button.addEventListener('click', function () {
      let quantityDisplay = this.parentElement.querySelector('.quantityDisplay');
      let quantity = parseInt(quantityDisplay.value);
      quantityDisplay.value = quantity + 1;
      calculateTotal(this);
  });
});

document.querySelectorAll('.decrement').forEach(function (button) {
  button.addEventListener('click', function () {
      let quantityDisplay = this.parentElement.querySelector('.quantityDisplay');
      let quantity = parseInt(quantityDisplay.value);
      if (quantity > 1) {
          quantityDisplay.value = quantity - 1;
      }
      calculateTotal(this);
  });
});

   // Initialize toasts when the DOM is fully loaded
   document.addEventListener("DOMContentLoaded", function() {
    // Initialize and show each toast if present
    ['successToast', 'errorToast', 'messageToast'].forEach(id => {
        const toastElement = document.getElementById(id);
        if (toastElement) {
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Select all elements with the class 'glider'
    document.querySelectorAll('.glider').forEach((glider) => {
        new Glider(glider, {
            slidesToShow: 2,
            slidesToScroll: 4,
            draggable: true,
            duration: 1.2, // Adjust the animation duration in seconds (default is 0.5)
            dragVelocity: 1.2,
            arrows: {
                prev: glider.parentElement.querySelector('.glider-prev'),
                next: glider.parentElement.querySelector('.glider-next')
            },
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }
            ]
        });
    });
});

// Add event listener for 'add-to-cart-btn'
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', () => {
        const cartPopup = document.querySelector('.cart-popup');
        if (cartPopup) {
            // Save the popup state to localStorage
            localStorage.setItem('showCartPopup', 'true');
        }
    });
});

// Check localStorage after page reload
window.addEventListener('load', () => {
    const cartPopup = document.querySelector('.cart-popup');
    if (cartPopup && localStorage.getItem('showCartPopup') === 'true') {
        // Apply popup styles on load
        cartPopup.style.opacity = "1";
        cartPopup.style.transform = "scale(1)";

        // Reset the popup state and remove from localStorage
        setTimeout(() => {
            cartPopup.style.opacity = "0";
            cartPopup.style.transform = "scale(0)";
            localStorage.removeItem('showCartPopup');
        }, 3000); // 3 seconds
    }
});




