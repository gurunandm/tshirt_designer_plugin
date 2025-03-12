jQuery(document).ready(function ($) {
    const canvas = document.getElementById('tshirt-canvas');
    const ctx = canvas.getContext('2d');
    const tshirtImage = document.getElementById('tshirt-image');
    const logoImage = document.getElementById('logo-image');

    let currentColor = '#000000'; 
    let logoPosition = { x: 0, y: 0 };
    let logoSize = 80;
    let textPosition = { x: 50, y: 50 }; 
    let textSize = 30;
    let isDragging = false;
    let dragStartPoint = { x: 0, y: 0 };

    let customText = ""; 
    let textColor = "#000000"; 
    let selectedElement = 'text'; 
    let selectedFont = 'Arial';

    // Resize the canvas to match the T-shirt image
    function resizeCanvas() {
        canvas.width = tshirtImage.width;
        canvas.height = tshirtImage.height;
        drawTshirt(currentColor);
    }

    function drawTshirt(color) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = color;
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.globalCompositeOperation = 'destination-in';
        ctx.drawImage(tshirtImage, 0, 0, canvas.width, canvas.height);
        ctx.globalCompositeOperation = 'source-over';

        if (logoImage.src) {
            ctx.drawImage(logoImage, logoPosition.x, logoPosition.y, logoSize, logoSize);
        }

        if (customText) {
            ctx.font = `${textSize}px ${selectedFont}`; // Use selected font
            ctx.fillStyle = textColor;
            ctx.fillText(customText, textPosition.x, textPosition.y);
        }
    }

    resizeCanvas();
    $(window).on('resize', resizeCanvas);

    $('#tshirt-color').on('input', function () {
        currentColor = $(this).val();
        drawTshirt(currentColor);
    });

    $('#logo-upload').on('change', function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function (e) {
            logoImage.src = e.target.result;
            logoImage.onload = function () {
                drawTshirt(currentColor);
            }
        };
        if (file) reader.readAsDataURL(file);
    });

    // Handle dragging based on selected element
    $('.tshirt-preview').on('mousedown', function (e) {
        isDragging = true;
        const rect = canvas.getBoundingClientRect();

        if (selectedElement === 'image') {
            dragStartPoint.x = e.offsetX - logoPosition.x;
            dragStartPoint.y = e.offsetY - logoPosition.y;
        } else if (selectedElement === 'text') {
            dragStartPoint.x = e.offsetX - textPosition.x;
            dragStartPoint.y = e.offsetY - textPosition.y;
        }
        $(this).css('cursor', 'grabbing');
    });

    $(document).on('mouseup', function () {
        isDragging = false;
        $('.tshirt-preview').css('cursor', 'default');
    });

    $(document).on('mousemove', function (e) {
        if (isDragging) {
            const rect = canvas.getBoundingClientRect();
            if (selectedElement === 'image') {
                logoPosition.x = e.clientX - rect.left - dragStartPoint.x;
                logoPosition.y = e.clientY - rect.top - dragStartPoint.y;
            } else if (selectedElement === 'text') {
                textPosition.x = e.clientX - rect.left - dragStartPoint.x;
                textPosition.y = e.clientY - rect.top - dragStartPoint.y;
            }
            drawTshirt(currentColor);
        }
    });

    $('#logo-size').on('input', function () {
        logoSize = $(this).val();
        $('#logo-size-value').text(logoSize + ' px');
        drawTshirt(currentColor);
    });

    // Handle custom text input
    $('#custom-text').on('input', function () {
        customText = $(this).val();
        drawTshirt(currentColor);
    });

    // Handle text color change
    $('#text-color').on('input', function () {
        textColor = $(this).val();
        drawTshirt(currentColor);
    });


    // Handle text size change
    $('#text-size').on('input', function () {
        textSize = $(this).val();
        $('#text-size-value').text(textSize + ' px');
        drawTshirt(currentColor);
    });

    // Update selected element based on dropdown
    $('#select-element').on('change', function () {
        selectedElement = $(this).val();
    });

    // Update selected font based on dropdown
    $('#font-family').on('change', function () {
        selectedFont = $(this).val();
        drawTshirt(currentColor); 
    });
});