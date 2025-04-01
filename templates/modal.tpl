<div class="modal" id="viewSubmissionFilesModal">
    <div class="modal-content">
        <h2>Ver Archivos de Envíos</h2>
        <ul id="file-list">
            <!-- Los archivos se añadirán dinámicamente aquí -->
        </ul>
        <button class="close" onclick="closeModal()">Cerrar</button>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('viewSubmissionFilesModal').style.display = 'none';
    }

    function openModal(files) {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = '';
        files.forEach(file => {
            const listItem = document.createElement('li');
            listItem.innerHTML = `<a href="${file.url}" target="_blank">${file.name}</a>`;
            fileList.appendChild(listItem);
        });
        document.getElementById('viewSubmissionFilesModal').style.display = 'block';
    }
</script>
