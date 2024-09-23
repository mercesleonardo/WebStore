export default {
    isMenuOpen: false,
    items: [],

    init() {

    },

    toggleCartMenu() {
        this.isMenuOpen = !this.isMenuOpen;
    },

    closeCartMenu() {
        this.isMenuOpen = false;
    }
}