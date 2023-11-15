import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja.js";

flatpickr("#startDate", {
    local: Japanese,
    dateFormat: "Y-m-d",
});

flatpickr("#endDate", {
    local: Japanese,
    dateFormat: "Y-m-d",
});
