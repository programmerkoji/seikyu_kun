import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Japanese } from "flatpickr/dist/l10n/ja.js";

flatpickr("#posting_start", {
    locale: Japanese,
    dateFormat: "Y-m-d",
});
