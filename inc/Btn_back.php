<div class="btn-container">
    <button class="btn-back">Regresar atrás</button>
</div>

<script type="text/javascript">
    const $btnBack = document.querySelector('.btn-back');
    $btnBack.addEventListener('click', (e)=>{
        e.preventDefault();
        window.history.back();
    });
</script>