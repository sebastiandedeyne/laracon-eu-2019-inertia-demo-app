import Vue from 'vue';
import { format as formatDate, parseISO } from 'date-fns';
import upperFirst from 'lodash/upperFirst';

Vue.config.productionTip = false;

// Auto-register all Vue components in ./Shared
const files = require.context('./Shared', true, /\.vue$/i);
files.keys().map(key => {
    return Vue.component(
        key
            .split('/')
            .pop()
            .split('.')[0],
        files(key).default
    );
});

Vue.filter('date', (date, format = 'yyyy/MM/dd') => {
    if (!date) {
        return '-';
    }

    if (typeof date === 'string') {
        date = parseISO(date);
    }

    return formatDate(date, format);
});

Vue.filter('upperFirst', upperFirst);
