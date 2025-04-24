<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <style>
        img {
            width: 25px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <img src="svg/three-dots.svg" alt="menu" id="span-id">
    <div id="del-container" style='display: none;'></div>
    <script>
        const openBtn = document.getElementById('span-id');
        const delContainer = document.getElementById('del-container');
        openBtn.addEventListener('click', () => {
            if (delContainer.style.display === 'none') {
                delContainer.style.display = 'flex';
                delContainer.style.backgroundColor = 'red';
                delContainer.style.width = '100px';
                delContainer.style.height = '100px';
                delContainer.style.userSelect = 'none';
            } else {
                delContainer.style.display = 'none';
            }
        });
    </script>
</body>

</html>