'use strict';
document.addEventListener('DOMContentLoaded', function () {
    const copyButtons = document.querySelectorAll('.mwt-copy-btn');

    copyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const img = button.previousElementSibling; // Get the associated image
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;

            context.drawImage(img, 0, 0);

            canvas.toBlob(blob => {
                const item = new ClipboardItem({'image/png': blob});
                navigator.clipboard.write([item]).then(() => {
                    button.textContent = 'Copied'; // Change button text to 'Copied'
                    button.classList.add('copied');
                    setTimeout(() => {
                        button.textContent = 'Copy'; // Reset after 2 seconds
                        button.classList.remove('copied');
                    }, 2000);
                }).catch(err => {
                    button.textContent = 'Failed'; // Change button text to 'Failed'
                    button.classList.add('failed');
                    setTimeout(() => {
                        button.textContent = 'Copy'; // Reset after 2 seconds
                        button.classList.remove('failed');
                    }, 2000);
                    console.error('Failed to copy: ', err);
                });
            });
        });
    });
});
