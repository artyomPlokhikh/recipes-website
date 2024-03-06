document.getElementById('ingredientNameValue').addEventListener('input', function () {

    var inputValue = this.value;


    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'server.php?ingredientNameValue=' + encodeURIComponent(inputValue), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            var wordSuggestions = JSON.parse(xhr.responseText);


            var datalist = document.getElementById('wordSuggestions');
            datalist.innerHTML = '';


            wordSuggestions.forEach(function (word) {
                var option = document.createElement('option');
                option.value = word;
                datalist.appendChild(option);
            });
        }
    };
    xhr.send();
});