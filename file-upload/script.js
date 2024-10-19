document.addEventListener('DOMContentLoaded', function () {
    let fileInput = document.getElementById('file-upload');
    let fileNameDiv = document.getElementById('file-name');

    let btnUpload = document.querySelector("#btn-upload");

    fileInput.addEventListener('change', function () {
        // Verifica se algum arquivo foi selecionado
        if (fileInput.files.length > 0) {
            btnUpload.disabled = false;
            btnUpload.classList.remove('btn-disabled');
            btnUpload.classList.add('btn-active');
            let fileName = fileInput.files[0].name;
            fileNameDiv.textContent = fileName;
        } else {
            btnUpload.disabled = true;
            btnUpload.classList.add('btn-disabled');
            btnUpload.classList.remove('btn-active');
            fileNameDiv.textContent = 'Nenhum arquivo selecionado';
        }
    });
});
