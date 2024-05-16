const days = 24 * 60 * 60;
const hours = 60 * 60;
const minutes = 60;

function countdown ( container, countdownElement, prop ) {
  const options = Object.assign( {
    callback: function () { },
    timestamp: 0
  }, prop );

  let left, d, h, m, s, positions;

  init( container, countdownElement, options );
  positions = countdownElement.querySelectorAll( '.position' );

  ( function tick () {
    left = Math.floor( ( options.timestamp - new Date() ) / 1000 );

    if ( left < 0 ) {
      left = 0;
    }

    d = Math.floor( left / days );
    updateDuo( 0, 1, d );
    left -= d * days;

    h = Math.floor( left / hours );
    updateDuo( 2, 3, h );
    left -= h * hours;

    m = Math.floor( left / minutes );
    updateDuo( 4, 5, m );
    left -= m * minutes;

    s = left;
    updateDuo( 6, 7, s );

    options.callback( d, h, m, s );
    setTimeout( tick, 1000 );
  } )();

  function updateDuo ( minor, major, value ) {
    switchDigit( positions[ minor ], Math.floor( value / 10 ) % 10 );
    switchDigit( positions[ major ], value % 10 );
  }

  return countdownElement;
}

function init ( container, countdownElement, options ) {
  const { dataset } = container.querySelector( '.lms-course-list-item-countdown' );

  countdownElement.classList.add( 'countdownHolder' );
  const timeUnits = [ 'Days', 'Hours', 'Minutes', 'Seconds' ];
  const timeLabels = [ dataset.days, dataset.hours, dataset.minutes, dataset.seconds ];

  timeUnits.forEach( ( unit, index ) => {
    const label = timeLabels[ index ];
    const unitElement = document.createElement( 'span' );
    unitElement.className = 'count' + unit;
    unitElement.innerHTML = `<div class="countdown_label">${ label }</div>
        <span class="position">
          <span class="digit static">0</span>
        </span>
        <span class="position">
          <span class="digit static">0</span>
        </span>`;
    countdownElement.appendChild( unitElement );

    if ( unit !== 'Seconds' ) {
      const divElement = document.createElement( 'span' );
      divElement.className = `countDiv countDiv${ index }`;
      countdownElement.appendChild( divElement );
    }
  } );
}

function switchDigit ( position, number ) {
  const digit = position.querySelector( '.digit' );
  const currentNumber = digit.textContent;

  if ( currentNumber == number ) {
    return;
  }

  const replacement = document.createElement( 'span' );
  replacement.className = 'digit';
  replacement.textContent = number;

  position.dataset.digit = number;
  position.appendChild( replacement );

  digit.classList.remove( 'static' );
  replacement.style.opacity = "0";

  setTimeout( () => {
    digit.remove();
    replacement.classList.add( 'static' );
    replacement.style.opacity = '1';
  }, 250 );
}
