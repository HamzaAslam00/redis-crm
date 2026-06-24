<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsAndFaqsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTestimonials();
        $this->seedFaqCategories();
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'Ahmed Khan',
                'role' => 'CEO',
                'company' => 'TechManage Pvt. Ltd.',
                'quote' => 'Redis Solution transformed our outdated inventory system into a full ERP platform in under 3 months. Results were impressive — 40% faster order processing.',
                'rating' => 5,
                'avatar_color' => '#FF6400',
                'initials' => 'AK',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Mark Jensen',
                'role' => 'CEO',
                'company' => 'Agnatech',
                'quote' => 'They delivered our Flutter mobile app on time and within budget. Runs flawlessly on both iOS and Android. Communication was exceptional throughout.',
                'rating' => 5,
                'avatar_color' => '#6366F1',
                'initials' => 'MJ',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Omar Raza',
                'role' => 'Marketing Director',
                'company' => 'PakBazar',
                'quote' => 'SEO rankings went from page 5 to #1 in 4 months. ROAS on Google Ads improved by 280%. Redis Solution delivers exactly what they promise.',
                'rating' => 5,
                'avatar_color' => '#10B981',
                'initials' => 'OR',
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'Sarah Mitchell',
                'role' => 'Founder',
                'company' => 'BrightEdge Solutions',
                'quote' => 'Working with Redis Solution was a game changer. They understood our business needs instantly and delivered a website that significantly boosted enquiries.',
                'rating' => 5,
                'avatar_color' => '#EC4899',
                'initials' => 'SM',
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'name' => 'Zubair Malik',
                'role' => 'CTO',
                'company' => 'Finova Tech',
                'quote' => 'The AI chatbot they built handles 70% of customer queries automatically. Incredible ROI from day one.',
                'rating' => 5,
                'avatar_color' => '#F59E0B',
                'initials' => 'ZM',
                'is_active' => true,
                'display_order' => 5,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::firstOrCreate(['name' => $data['name'], 'company' => $data['company']], $data);
        }
    }

    private function seedFaqCategories(): void
    {
        $categories = [
            [
                'name' => 'Working with Us',
                'icon' => 'ri-team-line',
                'display_order' => 1,
                'is_active' => true,
                'faqs' => [
                    ['q' => 'How long does a typical project take?', 'a' => 'Project timelines vary based on scope and complexity. A simple landing page can be delivered in 1–2 weeks. A standard business website takes 3–5 weeks. Complex web applications or mobile apps typically run 6–16 weeks. We always share a detailed timeline with milestones before any work begins so you know exactly what to expect.', 'order' => 1],
                    ['q' => 'What information do you need to start?', 'a' => "To provide an accurate quote we need a rough description of what you want built, your target launch date and an approximate budget range. Any existing designs, brand guidelines or references you have are helpful but not required at this stage. We'll schedule a discovery call to fill in the gaps before anything is formalised.", 'order' => 2],
                    ['q' => 'Do you work with international clients?', 'a' => "Yes — we regularly work with clients in the UK, UAE, USA, Canada and Australia. All our project communication is in English and we use industry-standard collaboration tools (Notion, Linear, Slack, Figma) to keep remote teams fully aligned. Time zone differences are manageable and we're flexible with overlap hours.", 'order' => 3],
                    ['q' => 'How do you handle project communication?', 'a' => 'Every project has a dedicated project manager who is your single point of contact. We hold weekly status calls (or bi-weekly for smaller projects), share updates via Slack or WhatsApp and use Linear or Jira for task tracking. You have full visibility into progress at all times — no chasing required.', 'order' => 4],
                    ['q' => 'Do you sign NDAs?', 'a' => "Absolutely. We sign non-disclosure agreements before any sensitive business information is shared. Our standard NDA is mutual, covers all information exchanged during both pre-sales and active project phases and is drafted to be fair to both parties. We can also review and sign your company's NDA if you prefer.", 'order' => 5],
                ],
            ],
            [
                'name' => 'Pricing & Payment',
                'icon' => 'ri-money-dollar-circle-line',
                'display_order' => 2,
                'is_active' => true,
                'faqs' => [
                    ['q' => 'How much does a website cost?', 'a' => "Pricing depends heavily on scope. A simple brochure website typically starts at around \$500–\$1,500. A full e-commerce store or custom web application can range from \$2,000 to \$15,000+. We don't believe in one-size-fits-all pricing — we'll give you a detailed, itemised quote after understanding your specific requirements. There's no cost for the initial consultation or quote.", 'order' => 1],
                    ['q' => 'What payment methods do you accept?', 'a' => 'We accept bank transfers (local and international SWIFT/IBAN), Payoneer, Wise and cryptocurrency (USDT/BTC). For Pakistani clients we also accept Easypaisa, JazzCash and direct bank transfer. Invoices are issued in USD, GBP or PKR depending on your preference.', 'order' => 2],
                    ['q' => 'Do you offer payment plans?', 'a' => "Yes. Our standard payment structure is 40% upfront to begin work, 30% at the mid-project milestone and the final 30% on delivery. For larger projects (\$5,000+) we can arrange custom milestone-based payment schedules. We don't require full payment before starting — we understand that building trust is a two-way process.", 'order' => 3],
                    ['q' => 'Are there any hidden costs?', 'a' => 'No. Our quotes are fully itemised and include all development, design and project management costs. Any third-party costs (domain, hosting, premium fonts, paid APIs or stock images) are clearly listed separately before you commit. If scope changes during the project we discuss it openly and agree on any additional cost before proceeding.', 'order' => 4],
                ],
            ],
            [
                'name' => 'Technical',
                'icon' => 'ri-code-s-slash-line',
                'display_order' => 3,
                'is_active' => true,
                'faqs' => [
                    ['q' => 'Who owns the code after project completion?', 'a' => "You do — 100%. On final payment we transfer full ownership of all source code, design assets and associated intellectual property to you. We'll push the complete codebase to a Git repository of your choice and hand over all credentials. We retain no rights over your software.", 'order' => 1],
                    ['q' => 'Do you offer hosting?', 'a' => "We can set up and configure hosting on your preferred provider (AWS, DigitalOcean, Laravel Cloud, Hostinger, etc.) as part of the project, or we can manage hosting and server maintenance on an ongoing monthly basis. We recommend you own the hosting account directly so you're never dependent on us for access.", 'order' => 2],
                    ['q' => 'Can you maintain and update our existing website?', 'a' => "Yes. We offer monthly maintenance retainers that include security updates, plugin/dependency upgrades, uptime monitoring, regular backups and a set number of content or minor feature change hours per month. We're also happy to perform one-off audits, performance improvements or security hardening on existing sites we didn't build.", 'order' => 3],
                    ['q' => 'What happens after launch?', 'a' => "All projects include a 30-day post-launch support period during which we fix any bugs that arise at no additional cost. After that you can choose a maintenance retainer for ongoing support or engage us ad-hoc for future improvements. We don't disappear after handover — most of our clients come back to us for additional projects.", 'order' => 4],
                ],
            ],
            [
                'name' => 'Services',
                'icon' => 'ri-apps-line',
                'display_order' => 4,
                'is_active' => true,
                'faqs' => [
                    ['q' => 'Do you do design only, without development?', 'a' => 'Yes. We offer standalone UI/UX design services including wireframing, high-fidelity mockups in Figma and clickable prototypes. Many clients come to us for design work and then hand the Figma files to their in-house developers. We can also review and improve existing designs.', 'order' => 1],
                    ['q' => 'Can you help with an existing project someone else started?', 'a' => "Absolutely. We're comfortable taking over partially-built projects. We'll start with a thorough code review to understand what exists, identify any technical debt and propose a clear path forward. We don't charge for the initial code review on projects above \$1,000.", 'order' => 2],
                    ['q' => 'Do you offer SEO with every website?', 'a' => "Every website we build is technically SEO-ready out of the box — that means semantic HTML, fast load times, proper meta tags, schema markup and a clean URL structure. Full ongoing SEO (keyword research, link building, content strategy) is a separate service. We'll always recommend whether you need it based on your goals.", 'order' => 3],
                ],
            ],
        ];

        foreach ($categories as $catData) {
            $faqs = $catData['faqs'];
            unset($catData['faqs']);

            $category = FaqCategory::firstOrCreate(['name' => $catData['name']], $catData);

            foreach ($faqs as $faqData) {
                Faq::firstOrCreate(
                    ['faq_category_id' => $category->id, 'question' => $faqData['q']],
                    [
                        'answer' => $faqData['a'],
                        'display_order' => $faqData['order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
