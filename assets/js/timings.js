'use strict';
document.addEventListener('DOMContentLoaded', e => {
    const nextButtons = document.querySelectorAll('.oa-button-next');
    const previousButtons = document.querySelectorAll('.oa-button-previous');
    const months = document.querySelectorAll('.oa-month');

    previousButtons[0].setAttribute('disabled', true);
    nextButtons[nextButtons.length - 1].setAttribute('disabled', true);

    let currentIndex = 0;
    months.forEach((month, index) => {
        if (month.classList.contains('oa-current')) {
            currentIndex = index;
        }
    });

    previousButtons.forEach(button => {
        button.addEventListener('click', e => {
            currentIndex -= 1;
            if (currentIndex < 0) currentIndex = 0;
            updateActiveMonth(currentIndex);
        });
    });

    nextButtons.forEach(button => {
        button.addEventListener('click', e => {
            currentIndex += 1;
            if (currentIndex >= months.length) currentIndex = months.length - 1;
            updateActiveMonth(currentIndex);
        });
    });

    const updateActiveMonth = newIndex => {
        months.forEach((month, index) => {
            const className = newIndex === index ? 'oa-current' : 'oa-hidden';
            month.classList.remove('oa-hidden', 'oa-current');
            month.classList.add(className);
        });
    }
});