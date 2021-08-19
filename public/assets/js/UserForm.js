$(function() {
    'use strict';
    var inputs = document.querySelectorAll('.file');
    Array.prototype.forEach.call(inputs, function(input) {
        var label = input.nextElementSibling,
            labelVal = label.innerHTML;
        input.addEventListener('change', function(e) {
            var fileName = '';
            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else
                fileName = e.target.value.split("'\'").pop();
            if (fileName) {
                label.querySelector('span').innerHTML = fileName;
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = function() {
                    let preview = document.getElementById('imagenPrevisualizacion');
                    preview.src = reader.result;
                };

            } else {
                label.innerHTML = labelVal;
            }
        });
    });
});