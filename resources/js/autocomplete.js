import autoComplete from "@tarekraafat/autocomplete.js";

document.addEventListener("DOMContentLoaded", () => {
    let companyData = [];
    const autoCompleteJS = new autoComplete({
        selector: "#company",
        data: {
            src: async (query) => {
                try {
                    const source = await fetch(`/autocomplete?query=${query}`);
                    const data = await source.json();
                    companyData = data;
                    return data.map((item) => item.name);
                } catch (error) {
                    console.log(error);
                    return [];
                }
            },
        },
        resultsList: {
            element: (list, data) => {
                if (!data.results.length) {
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span>該当する結果が見つかりませんでした: "${data.query}"</span>`;
                    list.prepend(message);
                }
            },
            noResults: true,
            id: "company_list",
        },
        events: {
            input: {
                selection: (event) => {
                    const selection = event.detail.selection.value;
                    autoCompleteJS.input.value = selection;

                    const selectedCompany = companyData.find(company => company.name === selection);
                    if (selectedCompany) {
                        document.getElementById('company_id').value = selectedCompany.id;
                    }
                },
            },
        },
        resultItem: {
            highlight: true,
        },
        tabSelect: true,
    });
});
