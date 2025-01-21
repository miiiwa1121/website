let flippedCards = [];
let lockBoard = false;
let matchedCards = 0;
const totalPairs = document.querySelectorAll('.card').length / 2;

document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', () => {
        if (lockBoard || card.classList.contains('flipped')) return;

        card.classList.add('flipped');
        flippedCards.push(card);

        if (flippedCards.length === 2) {
            checkForMatch();
        }
    });
});

function checkForMatch() {
    const [card1, card2] = flippedCards;

    if (card1.dataset.image === card2.dataset.image) {
        showCardName(card1);
        showCardName(card2);
        disableCards();
        matchedCards++;
        if (matchedCards === totalPairs) {
            showGameOver();
        }
    } else {
        unflipCards();
    }
}

function showCardName(card) {
    const name = card.querySelector('.card-name').dataset.name;
    card.querySelector('.card-name').textContent = name;
    card.querySelector('.card-name').style.display = 'block';
}

function disableCards() {
    flippedCards = [];
}

function unflipCards() {
    lockBoard = true;
    setTimeout(() => {
        flippedCards.forEach(card => card.classList.remove('flipped'));
        flippedCards = [];
        lockBoard = false;
    }, 1000);
}

function showGameOver() {
    document.getElementById('game-over').style.display = 'block';
}
