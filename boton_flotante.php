<!-- boton_flotante.php -->
<button class="floating-button" onclick="location.href='home.php'">+</button>

<style>
    /* Estilos del botón flotante */
    .floating-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #4CAF50;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .floating-button:hover {
        background-color: #45a049;
    }
</style>
