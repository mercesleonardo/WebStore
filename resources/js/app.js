import Alpine from "alpinejs";
import cart from "./cart.js";
import "./toast";
import './helpers/money.js'

window.Alpine = Alpine;

Alpine.store('cart', cart);
Alpine.start();