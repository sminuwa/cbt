@extends('layouts.candidate')

@section('content')
    <div class="clock" id="clock">02:00:00</div>


    <div class="calculator">
        <div class="calculator-header">
            <span class="calculator-title">Calculator</span>
            <button id="toggle-calculator" class="toggle-button">-</button>
        </div>
        <div id="calculator-body">
            <input id="calculator-display" type="text" class="calculator-display" readonly />
            <div class="calculator-grid">
                <button onclick="appendNumber('7')" class="calculator-button">7</button>
                <button onclick="appendNumber('8')" class="calculator-button">8</button>
                <button onclick="appendNumber('9')" class="calculator-button">9</button>
                <button class="calculator-button operator-button" onclick="appendOperator('/')">/</button>
                <button onclick="appendNumber('4')" class="calculator-button">4</button>
                <button onclick="appendNumber('5')" class="calculator-button">5</button>
                <button onclick="appendNumber('6')" class="calculator-button">6</button>
                <button class="calculator-button operator-button" onclick="appendOperator('*')">*</button>
                <button onclick="appendNumber('1')" class="calculator-button">1</button>
                <button onclick="appendNumber('2')" class="calculator-button">2</button>
                <button onclick="appendNumber('3')" class="calculator-button">3</button>
                <button class="calculator-button operator-button" onclick="appendOperator('-')">-</button>
                <button onclick="appendNumber('0')" class="calculator-button">0</button>
                <button onclick="appendNumber('.')" class="calculator-button">.</button>
                <button class="calculator-button operator-button" onclick="clearDisplay()">C</button>
                <button class="calculator-button operator-button" onclick="appendOperator('+')">+</button>
                <button class="calculator-button equal-button" onclick="calculateResult()">=</button>
            </div>
            <button id="toggle-scientific" class="scientific-button">Scientific</button>
            <div id="scientific-operations" class="scientific-operations hidden">
                <button onclick="appendFunction('sin')" class="calculator-button">sin</button>
                <button onclick="appendFunction('cos')" class="calculator-button">cos</button>
                <button onclick="appendFunction('tan')" class="calculator-button">tan</button>
                <button onclick="appendFunction('log')" class="calculator-button">log</button>
                <button onclick="appendFunction('sqrt')" class="calculator-button">√</button>
                <button onclick="appendFunction('pow')" class="calculator-button">x^y</button>
                <button onclick="appendFunction('pi')" class="calculator-button">π</button>
                <button onclick="appendFunction('e')" class="calculator-button">e</button>
            </div>
        </div>
    </div>


@endsection

@push('style')
    <style>
        .clock {
            font-size: 2rem;
            font-family: Arial, sans-serif;
            margin: 20px;
            color: green; /* Initial color set to green */
        }
    </style>
    <style>
        .calculator {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            background-color: var(--bg-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 1rem;
            width: 16rem;
            z-index: 9999;
        }

        .calculator-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .calculator-title {
            font-weight: bold;
            color: var(--text-color);
        }

        .toggle-button {
            color: var(--text-color);
            background-color: var(--button-bg-color);
            padding: 0.5rem;
            border-radius: 0.25rem;
        }

        .calculator-display {
            width: 100%;
            padding: 0.5rem;
            text-align: right;
            background-color: var(--input-bg-color);
            color: var(--text-color);
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .calculator-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }
        .toggle-button, .calculator-display, .calculator-button, .scientific-button{
            border:none;
        }

        .calculator-button {
            padding: 0.5rem;
            background-color: var(--button-bg-color);
            border-radius: 0.25rem;
        }

        .operator-button {
            background-color: var(--operator-bg-color);
        }

        .equal-button {
            grid-column: span 4;
            background-color: var(--equal-bg-color);
        }

        .scientific-button {
            margin-top: 1rem;
            width: 100%;
            padding: 0.5rem;
            background-color: var(--button-bg-color);
            border-radius: 0.25rem;
        }

        .scientific-operations {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .hidden {
            display: none;
        }

        :root {
            --bg-color: #ffffff;
            --text-color: #1a202c;
            --button-bg-color: #e2e8f0;
            --operator-bg-color: #f6ad55;
            --equal-bg-color: #48bb78;
            --input-bg-color: #edf2f7;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #1a202c;
                --text-color: #edf2f7;
                --button-bg-color: #4a5568;
                --operator-bg-color: #dd6b20;
                --equal-bg-color: #2f855a;
                --input-bg-color: #2d3748;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        function startTimer(duration, display) {
            let timer = duration, hours, minutes, seconds;
            const interval = setInterval(() => {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = hours + ":" + minutes + ":" + seconds;

                // Change color to red when 15 minutes (900 seconds) are left
                if (timer <= 900) {
                    display.style.color = 'red';
                }

                if (--timer < 0) {
                    clearInterval(interval);
                    alert("Time's up!");
                }
            }, 1000);
        }

        window.onload = function () {
            const twoHours = 60 * 60 * 2; // 2 hours in seconds
            const display = document.querySelector('#clock');
            startTimer(twoHours, display);
        };
    </script>
    <script>
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
    </script>
@endpush
