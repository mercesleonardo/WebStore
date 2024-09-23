import Alpine from "alpinejs";
import cart from "./cart.js";
import "./toast";

window.Alpine = Alpine;

Alpine.store('cart', cart);
Alpine.start();