<?php

function RenderIcon($category)
{
    switch (strtolower(trim($category))) {

        case 'food':
            return 'bi-cart3';

        case 'salary':
            return 'bi-wallet2';

        case 'utilities':
            return 'bi-lightning-charge';

        case 'transport':
            return 'bi-car-front';

        case 'shopping':
            return 'bi-bag';

        case 'freelance':
            return 'bi-laptop';

        case 'other':
            return 'bi-three-dots';

        default:
            return 'bi-tag';
    }
}