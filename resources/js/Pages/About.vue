<script setup>
import { ref, onMounted, watch,getCurrentInstance } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import ToggleLight from "@/Components/ToggleLight.vue";
import Logo from "@/Components/Logo.vue";
import BackButton from "@/Components/BackButton.vue";

const { t } = useI18n();
const props = usePage().props;
const { locale } = useI18n();
// Reactive variable to track the selected language
const language = ref('en'); // Default language

const { appContext } = getCurrentInstance();
const globalLanguage = appContext.config.globalProperties.$globalLanguage;
// Load saved language from local storage on mount
onMounted(() => {
    const { appContext } = getCurrentInstance();


    document.documentElement.setAttribute('dir', globalLanguage.selectedLanguage === 'ar' ? 'rtl' : 'ltr');


});

// Watch for language changes and update direction accordingly
watch(
            () => globalLanguage.selectedLanguage,
            (newLanguage) => {
                document.documentElement.setAttribute('dir', globalLanguage.selectedLanguage === 'ar' ? 'rtl' : 'ltr');

            }
        );
// const svgList = [
//     <svg width="48" height="48" fill="none" aria-hidden="true" class="mb-6 text-pink-500 dark:text-pink-400"><path d="M5 11a4 4 0 0 1 4-4h30a4 4 0 0 1 4 4v26a4 4 0 0 1-4 4H9a4 4 0 0 1-4-4V11Z" fill="currentColor" fill-opacity=".1" stroke="currentColor" stroke-width="2"></path><path d="M15 7v34" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>,
//     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#a39268" class="m-auto bi bi-journal" viewBox="0 0 16 16">
//         <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
//         <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
//     </svg>
// ]
const goToCategory = (id) => {
    route('category', { category: id });
};

</script>

<template>
    <BackButton />
    <title>{{ t('about_us') }}</title>
    <div>
        <ToggleLight style="position: fixed; direction: rtl; text-align: right;" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <div class="m-auto">
            <Logo class="w-52 m-auto" />
        </div>

        <div class="text-center mb-10">
            <div v-if="locale === 'ar'" class="container">
                <h1>تورك يابراك</h1>
                <p>تورك يابراك هي شركة متخصصة في إنتاج المنتجات الورقية والدفاتر بمختلف أنواعها. تعتبر الشركة من الشركات الرائدة في هذا المجال بفضل التزامها بالجودة العالية وتلبية احتياجات الأسواق المحلية والدولية.</p>
                <h2>منتجاتنا:</h2>
                <p>تورك يابراك تنتج مجموعة متنوعة من المنتجات الورقية:</p>
                <ul>
                    <li>دفاتر مدرسية بأحجام وتصاميم متعددة.</li>
                    <li>دفاتر احترافية لتلبية احتياجات الأفراد والشركات.</li>
                    <li>ورق طباعة عالي الجودة يناسب جميع أنواع الطابعات.</li>
                    <li>منتجات ورقية أخرى مثل المخططات وأوراق الرسم.</li>
                </ul>
                <h2>الجودة والابتكار:</h2>
                <p>الشركة تضمن الجودة من خلال استخدام أفضل المواد الخام وأحدث التقنيات. كما تسعى باستمرار للابتكار في تصاميمها.</p>
                <h2>الاستدامة:</h2>
                <p>تلتزم تورك يابراك بالاستدامة من خلال اختيار المواد الصديقة للبيئة وإدارة النفايات بطرق مسؤولة.</p>
                <h2>الوجود في السوق:</h2>
                <p>الشركة لديها وجود قوي في الأسواق المحلية والدولية، مما يجعلها الخيار المفضل للمدارس والشركات والمستهلكين.</p>
                <h2>25 عامًا من الخبرة:</h2>
                <p>بدأت الرحلة في فلسطين قبل 25 عامًا، واستمر النمو والتميز حتى إنشاء الشركة في تركيا حيث توسعت بشكل عالمي.</p>
                <div class="footer">© 2024 TORK YAPRAK - جميع الحقوق محفوظة</div>
            </div>

            <div v-if="locale === 'tr'" class="container">
                <h1>TORK YAPRAK</h1>
                <p>TORK YAPRAK, çeşitli tiplerde kağıt ürünleri ve defterlerin üretiminde uzmanlaşmış bir şirkettir. Şirket, yüksek kaliteli ürünler sunarak hem yerel hem de uluslararası pazarlarda lider bir konumdadır.</p>
                <h2>Ürünler:</h2>
                <p>Şirketin ürettiği bazı ürünler:</p>
                <ul>
                    <li>Çeşitli ebatlarda okul defterleri.</li>
                    <li>İşletmeler için profesyonel defterler.</li>
                    <li>Yüksek kaliteli baskı kağıtları.</li>
                    <li>Planlayıcılar ve eskiz kağıtları.</li>
                </ul>
                <h2>Kalite ve Yenilik:</h2>
                <p>En iyi hammaddeler ve en son teknolojiler kullanılarak kaliteli ve dayanıklı ürünler üretilmektedir.</p>
                <h2>Sürdürülebilirlik:</h2>
                <p>Çevreye duyarlı uygulamalarla sürdürülebilirlik odaklı üretim yapılır.</p>
                <h2>Pazarda Güçlü Konum:</h2>
                <p>Yerel ve uluslararası pazarlarda güçlü bir varlığa sahiptir.</p>
                <h2>25 Yıllık Deneyim:</h2>
                <p>Hikayemiz 25 yıl önce Filistin'de başladı ve Türkiye'ye genişleyerek uluslararası bir marka haline geldi.</p>
                <div class="footer">© 2024 TORK YAPRAK - Tüm hakları saklıdır</div>
            </div>

            <div v-if="locale === 'en'" class="container">
                <h1>TORK YAPRAK</h1>
                <p>TORK YAPRAK is a leading company specializing in the production of paper products and notebooks. Renowned for our commitment to quality, we serve local and international markets with products that meet the needs of students, professionals, and organizations.</p>
                <h2>Our Products:</h2>
                <p>We offer a wide range of paper products, including:</p>
                <ul>
                    <li>School notebooks in various sizes and designs.</li>
                    <li>Professional notebooks for business and personal use.</li>
                    <li>High-quality printing papers suitable for all printers.</li>
                    <li>Other products like planners and sketch papers.</li>
                </ul>
                <h2>Quality and Innovation:</h2>
                <p>We use the best raw materials and advanced technologies to produce durable, high-quality products.</p>
                <h2>Sustainability:</h2>
                <p>Sustainability is at the core of our operations, ensuring eco-friendly practices at every production stage.</p>
                <h2>Market Presence:</h2>
                <p>We are a trusted choice in local and global markets.</p>
                <h2>25 Years of Experience:</h2>
                <p>Our journey began in Palestine 25 years ago, expanding into Turkey to continue our path toward innovation.</p>
                <div class="footer">© 2024 TORK YAPRAK - All rights reserved</div>
            </div>
        </div>
    </div>
</template>


<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.rtl {
    direction: rtl;
    text-align: right;
}

.ltr {
    direction: ltr;
    text-align: left;
}

.logo {
    color: #333;
}

.menu-item2 {
    display: block;
    padding: 10px 20px;
    margin: 10px 0;
    background-color: #e7e7e7;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.menu-item2:hover {
    background-color: #d5d5d5;
}

.footer {
    margin-top: 20px;
    font-size: 0.9rem;
    color: #666;
}

.highlight {
    color: #FF6347;
    /* Highlight color */
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.rtl {
    direction: rtl;
    text-align: right;
}

.ltr {
    direction: ltr;
    text-align: left;
}

.logo {
    color: #a39268;
}

.menu-list {
    list-style-type: none;
    padding: 0;
}

.menu-item2 {
    position: relative;
    width: 80%;
    display: inline-table;
    background-color: #ffffff;
    color: #a39268;
    font-weight: 700;
    padding: 20px;
    margin: 10px auto;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transform: translateX(50%);
    opacity: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.menu-item2.enter {
    transform: translateX(0);
    opacity: 1;
}

.menu-item2:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    background-color: #f0e5d6;
}

.centered-div {
    display: inline-flex;
    justify-content: center;
}

.container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background-color: #FFF8DC;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    color: #A0522D;
    text-align: center;
    font-size: 2em;
}

h2 {
    color: #8B4513;
    font-size: 1.5em;
    margin-top: 20px;
}

p,
ul {
    font-size: 1em;
    margin-top: 15px;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li::before {
    content: "•";
    color: #8B4513;
    padding-right: 8px;
}

.highlight {
    color: #D2691E;
    font-weight: bold;
}

.footer {
    text-align: center;
    font-size: 0.9em;
    color: #5E3610;
    margin-top: 30px;
}
</style>
