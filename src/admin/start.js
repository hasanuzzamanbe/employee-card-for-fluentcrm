import routes from './routes';
import { createWebHashHistory, createRouter } from 'vue-router'
import EmployeeCard from './Bits/EmployeeCard';

const router = createRouter({
    history: createWebHashHistory(),
    routes
});


const framework = new EmployeeCard();


framework.app.config.globalProperties.appVars = window.EmployeeCardAdmin;

window.EmployeeCardApp = framework.app.use(router).mount('#employee_card_app');

router.afterEach((to, from) => {
    jQuery('.employee_card_menu_item').removeClass('active');
    let active = to.meta.active;
    if (active) {
        jQuery('.employee_card_main-menu-items').find('li[data-key='+active+']').addClass('active');
    }
});
