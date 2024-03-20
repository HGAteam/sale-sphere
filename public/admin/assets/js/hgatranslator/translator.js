// Function to load translations
function loadTranslations(locale) {
    return fetch(`/translations/${locale}`)
        .then(response => response.json())
        .catch(error => {
            console.error(error);
            return {};
        });
}

// lang object with translation function 't'.
const lang = {
    translations: {},
    t(key) {
        const translation = this.translations[key];
        if (translation !== undefined) {
            return translation;
        } else {
            return key;
        }
    }
};

// Content of the .js file to be translated
const content = ``;
// Get the value of locale from the HTML tag
const htmlLang = document.documentElement.lang;
const locale = htmlLang || 'en'; // If the lang attribute is not found, a default value is used (in this case, 'en').
// Load translations
loadTranslations(locale)
  .then(translations => {
    // Assign translations to the lang object
    lang.translations = translations;

    // Translate the contents of the .js file
    const translatedContent = content.replace(/lang.t\((.*?)\)/g, (match, p1) => {
      const key = p1.replace(/['"]/g, '');
      return lang.t(key);
    });

    // Execute the translated content
    eval(translatedContent);
  })
  .catch(error => {
    console.error(error);
  });
