import './css/style.css';

const $ = require('jquery'); 
global.$ = global.jQuery = $; 

require('bootstrap');

// NAVBAR > RESEARCH BAR //
/*
const serie = [
    {name: 'Stranger Thing'},
    {name: 'Breaking Bad'}
];

const searchinput = document.getElementById('searchInput');

searchinput.addEventListener('keyup', function(){
    const input = searchinput.value;

    const result = serie.filter(item => item.name.toLocaleLowerCase().includes(input.toLocaleLowerCase()));

    let suggestion = '';
    if(input !='' ){
    result.forEach(resultItem =>
        suggestion +=`
        <div class="suggestion">${resultItem.name}</div>
     `
    )
    }

    document.getElementById('suggestions').innerHTML = suggestion;
})
*/