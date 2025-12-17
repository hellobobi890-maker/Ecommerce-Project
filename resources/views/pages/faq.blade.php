@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <span class="text-primary fw-bold text-uppercase small">Help Center</span>
                    <h1 class="fw-bold mt-2 mb-3">Frequently Asked Questions</h1>
                    <p class="text-muted">Find answers to common questions about shopping with us.</p>
                </div>

                <!-- FAQ Accordion -->
                <div class="accordion" id="faqAccordion">
                    <!-- Orders & Shipping -->
                    <h5 class="fw-bold mb-3 mt-4"><i class="bi bi-truck me-2 text-primary"></i>Orders & Shipping</h5>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                Delivery kitne din mein hoti hai?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Major cities (Karachi, Lahore, Islamabad) mein 2-3 business days, other cities mein 3-5
                                business days,
                                aur remote areas mein 5-7 business days lagte hain. Peak seasons mein thoda zyada time lag
                                sakta hai.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                Shipping charges kitne hain?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                PKR 2,000 se oopar ke orders par <strong>FREE shipping</strong> hai.
                                PKR 2,000 se kam ke orders par PKR 200 flat rate shipping charge hai.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                Apna order kaise track karun?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Order dispatch hone ke baad aapko email aur SMS par tracking number milega.
                                Aap apne account mein login karke bhi order status dekh sakte hain.
                            </div>
                        </div>
                    </div>

                    <!-- Payments -->
                    <h5 class="fw-bold mb-3 mt-5"><i class="bi bi-credit-card me-2 text-primary"></i>Payments</h5>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq4">
                                Kaun se payment methods accept hain?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Hum Cash on Delivery (COD), Bank Transfer, aur Online Payment (Credit/Debit Cards) accept
                                karte hain.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq5">
                                Kya Cash on Delivery available hai?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Haan! COD service puray Pakistan mein available hai. Delivery ke waqt exact amount tayyar
                                rakhein.
                            </div>
                        </div>
                    </div>

                    <!-- Returns & Refunds -->
                    <h5 class="fw-bold mb-3 mt-5"><i class="bi bi-arrow-return-left me-2 text-primary"></i>Returns & Refunds
                    </h5>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq6">
                                Return policy kya hai?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Aap 30 din ke andar unused aur original condition mein product return kar sakte hain.
                                Tags attached hone chahiye aur original packaging mein hona chahiye.
                                <a href="{{ route('pages.return-policy') }}" class="text-primary">Return Policy</a> dekhen.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq7">
                                Refund kitne din mein milta hai?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Return accept hone ke baad 5-7 business days mein refund process ho jata hai.
                                Bank transfer ke case mein thoda zyada time lag sakta hai.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq8">
                                Exchange kaise karun?
                            </button>
                        </h2>
                        <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Size ya color exchange ke liye hamein WhatsApp ya email karein.
                                Aap product return karein aur hum naya product ship kar denge.
                            </div>
                        </div>
                    </div>

                    <!-- Account & Orders -->
                    <h5 class="fw-bold mb-3 mt-5"><i class="bi bi-person me-2 text-primary"></i>Account & Orders</h5>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq9">
                                Account banana zaroori hai?
                            </button>
                        </h2>
                        <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Order place karne ke liye account banana zaroori hai taake aap apne orders track kar sakein
                                aur future purchases mein address save rahe.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq10">
                                Order cancel kaise karun?
                            </button>
                        </h2>
                        <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Agar order abhi ship nahi hua, to aap hamein contact karke cancel karwa sakte hain.
                                Ship hone ke baad return policy apply hogi.
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <h5 class="fw-bold mb-3 mt-5"><i class="bi bi-box me-2 text-primary"></i>Products</h5>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq11">
                                Products original hain?
                            </button>
                        </h2>
                        <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Bilkul! Hum sirf 100% original aur high-quality products sell karte hain.
                                Har product quality check ke baad ship hota hai.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq12">
                                Size guide kahan hai?
                            </button>
                        </h2>
                        <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Har product page par size guide available hai. Agar phir bhi confusion ho,
                                to hamein WhatsApp par message karein aur hum aapki help karenge.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still Need Help -->
                <div class="text-center mt-5 p-5 bg-white rounded-4 shadow-sm">
                    <i class="bi bi-headset display-4 text-primary mb-3"></i>
                    <h4 class="fw-bold mb-3">Still Need Help?</h4>
                    <p class="text-muted mb-4">Can't find what you're looking for? Contact our support team.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('pages.contact') }}" class="btn btn-primary btn-lg px-4 rounded-pill">
                            <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                        <a href="https://wa.me/923001234567" target="_blank"
                            class="btn btn-success btn-lg px-4 rounded-pill">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .accordion-button:not(.collapsed) {
            background: var(--bg-light);
            color: var(--primary-color);
            font-weight: 600;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }

        .accordion-button::after {
            background-size: 1rem;
        }
    </style>
@endsection
