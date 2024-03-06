document.addEventListener('DOMContentLoaded', function () {

    var addIngredientBtn = document.getElementById("addIngredientBtn");
    var amountIntegerValue = document.getElementById("amountIntegerValue");
    var amountFractionValue = document.getElementById("amountFractionValue");
    var amountUnitValue = document.getElementById("amountUnitValue");
    var ingredientNameValue = document.getElementById("ingredientNameValue");
    var ingredientList = document.getElementById("ingredientList");



    
    
    const placeholderHTML = `
    <li class="recipe-creation-ingredients-list__item">
    <div class="recipe-creation-ingredients-list__measures">
    <span></span>
    <span></span>
    <span></span>
    </div>
    <div class="recipe-creation-ingredients-list__details">
    <span><p class="list__details-spaceholder">There's nothing here yet</p></span>
    </div>
    <div class="recipe-creation-ingredients-list__actions">
    </div>
    </li>
    `;
    
    if (ingredientList.innerHTML.trim() === '') {
        ingredientList.innerHTML = placeholderHTML;
    }
    
    

    function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    
    const fractionSymbols = {
        "half": "½",
        "third": "⅓",
        "quarter": "¼"
    }
    

    addIngredientBtn.addEventListener("click", function () {
        if (
            (amountIntegerValue.value !== "0" || amountFractionValue.value !== "0") &&
            amountUnitValue.value !== 'Please select...' &&
            ingredientNameValue.value.trim() !== "" 
            // &&
            // !hasSpecialCharacters(ingredientNameValue.value)
            ) {
                const integer = (amountIntegerValue.value === "0") ? "" : amountIntegerValue.value;
                const fraction = (amountFractionValue.value === "0") ? "" : fractionSymbols[amountFractionValue.value];
                
                let filteredName = escapeHtml(ingredientNameValue.value.toLowerCase())
                
                let listItemHTML = `
                <div class="recipe-creation-ingredients-list__measures">
                <span>${integer}</span>
                <span>${fraction}</span>
                <span>${amountUnitValue.value}</span>
                </div>
                <div class="recipe-creation-ingredients-list__details">
                <span>${filteredName}</span>
                </div>
                <div class="recipe-creation-ingredients-list__actions">
                <span class="delIngredientBtn" id="delIngredientBtn"><i class="fa-solid fa-xmark"></i></span>
                </div>
                
                <input type="hidden" name="ingredients[${filteredName}][amountInteger]" value="${amountIntegerValue.value}">
                <input type="hidden" name="ingredients[${filteredName}][amountFraction]" value="${amountFractionValue.value}">
                <input type="hidden" name="ingredients[${filteredName}][amountUnit]" value="${amountUnitValue.value}">
                <input type="hidden" name="ingredients[${filteredName}][ingredientName]" value="${filteredName}">
                `;
                
                if (ingredientList.innerHTML.includes(placeholderHTML)) {
                    ingredientList.innerHTML = '';
                }
                
                let listItem = document.createElement('li');
                listItem.classList.add('recipe-creation-ingredients-list__item');
                listItem.innerHTML = listItemHTML;
                
                ingredientList.appendChild(listItem);
                
                amountIntegerValue.selectedIndex = 0;
                amountFractionValue.selectedIndex = 0;
                amountUnitValue.selectedIndex = 0;
                ingredientNameValue.value = "";
            }
        });
        
        
        function deleteIngredient(element) {
            let listItem = element.closest("li");
            if (listItem) {
                listItem.remove();
            }
            
            if (ingredientList.innerHTML.trim() === ''){
                ingredientList.innerHTML = placeholderHTML
            }
        }
        
        ingredientList.addEventListener("click", function (e) {
            if (e.target.parentElement.classList.contains("delIngredientBtn")){
                deleteIngredient(e.target);
            }
        });
        
        
        
        
        
        const addStepBtn = document.getElementById("addStepBtn");
        const uploadRecipeStepTextarea = document.getElementById("uploadRecipeStepTextarea")
        const stepList = document.getElementById("stepList")
        
        if (stepList.innerHTML.trim() === '') {
            stepList.innerHTML = placeholderHTML;
        }
        
    addStepBtn.addEventListener("click", function () {
        let textareaValue = escapeHtml(uploadRecipeStepTextarea.value.trim())
        if (
            textareaValue !== "" 
            // &&
            // !hasSpecialCharacters(textareaValue)
            ) {
                let listItemHTML = `
                <div class="recipe-creation-step-list__details">
                <p class="step-details-text">${textareaValue}</p>
                </div>
                <div class="recipe-creation-step-list__actions">
                <span class="delStepBtn"><i class="fa-solid fa-xmark"></i></span>
                </div>
                
                <input type="hidden" name="step_description[]" value="${textareaValue}">
                
                
                `;
                
                if (stepList.innerHTML.includes(placeholderHTML)) {
                    stepList.innerHTML = `
                    
                    `;
                }
                
                
                let listItem = document.createElement('li');
                listItem.classList.add('recipe-creation-step-list__item');
                listItem.innerHTML = listItemHTML;
                
                stepList.appendChild(listItem);
                
                uploadRecipeStepTextarea.value = "";
            }
        });
        
        
        function deleteStep(element) {
        
            let listItem = element.closest("li");
        if (listItem) {
            listItem.remove();
        }
        
        
        if (stepList.innerHTML.trim() === ''){
            stepList.innerHTML = placeholderHTML
        }
    }
    
    stepList.addEventListener("click", function (e) {
        if (e.target.parentElement.classList.contains("delStepBtn")){
            deleteStep(e.target);
        }
    })
    



    
    document.getElementById('picture-upload-input').addEventListener('change', previewImage);

    function previewImage() {
    const fileInput = document.getElementById('picture-upload-input');
    const preview = document.getElementById('preview');

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
        preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
    }   


    



})