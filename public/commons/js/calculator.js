

    const display = document.getElementById('calculator-display');
    const calculatorBody = document.getElementById('calculator-body');
    const toggleButton = document.getElementById('toggle-calculator');
    const scientificOperations = document.getElementById('scientific-operations');
    const toggleScientificButton = document.getElementById('toggle-scientific');

    function appendNumber(number) {
    display.value += number;
}

    function appendOperator(operator) {
    display.value += ` ${operator} `;
}

    function appendFunction(func) {
    if (func === 'sqrt') {
    display.value += ` √(`;
} else if (func === 'pow') {
    display.value += ` ^ `;
} else if (func === 'pi') {
    display.value += Math.PI;
} else if (func === 'e') {
    display.value += Math.E;
} else {
    display.value += ` ${func}(`;
}
}

    function clearDisplay() {
    display.value = '';
}

    function calculateResult() {
    try {
    display.value = eval(display.value.replace(/√\(/g, 'Math.sqrt(').replace(/sin\(/g, 'Math.sin(').replace(/cos\(/g, 'Math.cos(').replace(/tan\(/g, 'Math.tan(').replace(/log\(/g, 'Math.log(').replace(/\^/g, '**').replace(/ /g, ''));
} catch {
    display.value = 'Error';
}
}

    toggleButton.addEventListener('click', () => {
    if (calculatorBody.style.display === 'none') {
    calculatorBody.style.display = 'block';
    toggleButton.textContent = '-';
} else {
    calculatorBody.style.display = 'none';
    toggleButton.textContent = '+';
}
});

    toggleScientificButton.addEventListener('click', () => {
    if (scientificOperations.style.display === 'none' || scientificOperations.style.display === '') {
    scientificOperations.style.display = 'grid';
} else {
    scientificOperations.style.display = 'none';
}
});

    document.addEventListener('keydown', (event) => {
    const key = event.key;
    if (!isNaN(key)) {
    appendNumber(key);
} else if (['+', '-', '*', '/'].includes(key)) {
    appendOperator(key);
} else if (key === 'Enter') {
    calculateResult();
} else if (key === 'Escape') {
    clearDisplay();
} else if (key === '.') {
    appendNumber('.');
}
});
