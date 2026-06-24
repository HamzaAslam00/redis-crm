<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\PortfolioItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogAndPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'hamzaaslam016@gmail.com')->first()
            ?? User::first();

        // ── Blog Categories ──────────────────────────────────────────────
        $categories = [
            ['name' => 'Web Development',    'color' => '#FF6400'],
            ['name' => 'Mobile Apps',         'color' => '#6366F1'],
            ['name' => 'AI & Automation',     'color' => '#EC4899'],
            ['name' => 'Digital Marketing',   'color' => '#10B981'],
            ['name' => 'Case Studies',        'color' => '#F59E0B'],
            ['name' => 'Company Updates',     'color' => '#0EA5E9'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['name']] = BlogCategory::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'color' => $cat['color']]
            );
        }

        // ── Blog Posts ────────────────────────────────────────────────────
        $posts = [
            [
                'title' => 'How We Built an AI Agent That Automates Client Onboarding',
                'category' => 'AI & Automation',
                'excerpt' => 'We integrated Claude AI and n8n to automate the full client onboarding flow — from contract signing to project kickoff, with zero human intervention.',
                'content' => '<h2>The Problem</h2><p>Every new client required 4–6 hours of manual back-and-forth: collecting requirements, signing NDAs, setting up project channels, and onboarding them to our tools. It was repetitive and error-prone.</p><h2>The Solution</h2><p>We built an AI agent using Claude API that collects requirements through a conversational form, generates a draft NDA, triggers DocuSign, creates a Notion project workspace, sends a Slack onboarding message, and schedules the kickoff call — all automatically.</p><h2>Tech Stack</h2><p>Claude API (claude-sonnet-4-6), n8n for workflow orchestration, DocuSign API, Notion API, Slack API, and a simple Laravel webhook receiver.</p><h2>Results</h2><p>Onboarding time reduced from 6 hours to 12 minutes. Client satisfaction scores went up 34% in the first month. The agent now handles 100% of new client onboarding with human review only at the final approval stage.</p><h2>Key Takeaway</h2><p>AI agents are not science fiction — they are production-ready tools that can replace repetitive human workflows today. The key is starting with a well-defined, bounded process.</p>',
                'meta_title' => 'AI Agent for Client Onboarding — Redis Solution',
                'meta_description' => 'How we built a Claude-powered AI agent to automate client onboarding from 6 hours to 12 minutes using n8n and Laravel.',
                'status' => 'published',
            ],
            [
                'title' => 'Laravel 13 vs Node.js — Which Should You Choose for Your Next SaaS?',
                'category' => 'Web Development',
                'excerpt' => 'After building dozens of SaaS products on both stacks, here is our honest comparison of Laravel 13 and Node.js for 2026.',
                'content' => '<h2>Overview</h2><p>Choosing the right backend framework is one of the most important decisions you will make for a new product. We have shipped SaaS products on both stacks and have strong opinions.</p><h2>When to Choose Laravel 13</h2><p>Laravel wins when you need rapid development, a full-featured ORM (Eloquent), built-in auth, queues, and a mature ecosystem. For B2B SaaS with standard CRUD-heavy features, Laravel is hard to beat. Its developer experience is exceptional and you can be production-ready in days, not weeks.</p><h2>When to Choose Node.js</h2><p>Node.js shines for real-time applications — chat apps, live dashboards, and anything requiring WebSocket connections at scale. Its non-blocking I/O model handles thousands of concurrent connections efficiently.</p><h2>Our Recommendation</h2><p>For most business SaaS products, choose Laravel. Its batteries-included approach, excellent documentation, and thriving community mean you ship faster and maintain better. Save Node.js for the parts of your system that genuinely need real-time throughput.</p>',
                'meta_title' => 'Laravel 13 vs Node.js for SaaS 2026',
                'meta_description' => 'Honest comparison of Laravel 13 and Node.js for building SaaS products in 2026 based on real-world projects.',
                'status' => 'published',
            ],
            [
                'title' => 'Flutter vs React Native in 2026 — What We Tell Every Client',
                'category' => 'Mobile Apps',
                'excerpt' => 'We have shipped 20+ mobile apps on both frameworks. Here is what we actually recommend to clients and why.',
                'content' => '<h2>The Short Answer</h2><p>Choose Flutter for most new mobile projects in 2026. Here is the longer explanation.</p><h2>Flutter Advantages</h2><p>Flutter\'s single codebase compiles to native code for iOS, Android, Web, and Desktop. Performance is excellent — no JavaScript bridge. The widget system is powerful and consistent across platforms. Dart is easy to learn for JavaScript developers.</p><h2>React Native Advantages</h2><p>React Native uses JavaScript, which your web team already knows. Code sharing with React web apps is possible. The ecosystem is mature with many battle-tested libraries.</p><h2>Our Verdict</h2><p>For brand new apps where you want the best performance and cross-platform consistency, Flutter is the clear winner. If your team is already strong in React and you need to share code with a web frontend, React Native makes sense.</p>',
                'meta_title' => 'Flutter vs React Native 2026 — Redis Solution',
                'meta_description' => 'Flutter vs React Native comparison 2026. Which cross-platform framework should you choose for your mobile app?',
                'status' => 'published',
            ],
            [
                'title' => 'Case Study: How We Doubled a PK E-Commerce Brand\'s Revenue With Meta Ads',
                'category' => 'Case Studies',
                'excerpt' => 'A Pakistani fashion brand was spending Rs. 3 lakh/month on Meta Ads with a 1.2x ROAS. We restructured their campaigns and took ROAS to 3.8x in 90 days.',
                'content' => '<h2>The Challenge</h2><p>Our client, a women\'s clothing brand based in Karachi, was burning through their ad budget with poor returns. Their campaigns were poorly structured, audiences were too broad, and creative testing was non-existent.</p><h2>Our Approach</h2><p>We started with a full audit of their Meta Ads account. Then we restructured into a proper funnel: broad interest targeting at the top, lookalike audiences in the middle, and retargeting warm audiences at the bottom.</p><h2>Creative Strategy</h2><p>We produced 12 video creatives and 20 static ad sets specifically for Pakistani audience preferences. UGC-style videos outperformed polished studio shoots by 3x.</p><h2>Results After 90 Days</h2><p>ROAS improved from 1.2x to 3.8x. Monthly revenue from Meta Ads grew from Rs. 3.6 lakh to Rs. 11.4 lakh. Cost per purchase dropped by 62%.</p>',
                'meta_title' => 'E-Commerce Meta Ads Case Study Pakistan — Redis Solution',
                'meta_description' => 'How Redis Solution took a Pakistani e-commerce brand from 1.2x to 3.8x ROAS on Meta Ads in 90 days.',
                'status' => 'published',
            ],
            [
                'title' => 'RAG Pipelines Explained: How We Give AI Agents Long-Term Memory',
                'category' => 'AI & Automation',
                'excerpt' => 'Retrieval Augmented Generation (RAG) allows AI agents to search and use your own data. Here is how we implement RAG pipelines for clients.',
                'content' => '<h2>What is RAG?</h2><p>Large Language Models like GPT-4o and Claude are powerful but they do not know anything about your specific business, documents, or data. RAG solves this by giving the AI a way to search your private knowledge base before answering.</p><h2>How It Works</h2><p>1. Your documents are chunked and converted into vector embeddings using an embedding model. 2. These embeddings are stored in a vector database (we use Pinecone or pgvector). 3. When a user asks a question, the question is also embedded and the most similar document chunks are retrieved. 4. These chunks are injected into the AI\'s context window along with the question. 5. The AI answers using your real data.</p><h2>When to Use RAG</h2><p>RAG is ideal for customer support bots trained on your documentation, internal knowledge base assistants, legal document Q&A tools, and any scenario where the AI needs to reference your specific business knowledge.</p><h2>Our Implementation</h2><p>We typically use Laravel + Python FastAPI for the RAG backend, Pinecone for vector storage, and either Claude or GPT-4o as the LLM. The full pipeline can be built and deployed in 2–4 weeks.</p>',
                'meta_title' => 'RAG Pipeline Implementation — Redis Solution AI',
                'meta_description' => 'How to implement RAG pipelines to give AI agents access to your private business data. Redis Solution AI services.',
                'status' => 'published',
            ],
            [
                'title' => 'Why Pakistani Businesses Need a Proper CRM in 2026',
                'category' => 'Company Updates',
                'excerpt' => 'Most Pakistani SMEs still manage clients and projects through WhatsApp and Excel. Here is why that is costing them growth.',
                'content' => '<h2>The Excel Problem</h2><p>We work with dozens of Pakistani businesses and the pattern is consistent: client contacts in WhatsApp, invoices in Excel, project status in a shared Google Sheet, and important decisions buried in email threads from 2023.</p><h2>What You Are Losing</h2><p>Without a proper CRM, you cannot track your sales pipeline, measure conversion rates, follow up reliably with leads, or understand which services are most profitable. You are making decisions based on gut feeling rather than data.</p><h2>What a CRM Changes</h2><p>A proper CRM gives you: full client history in one place, automated follow-up reminders, project status visibility for the whole team, financial reporting, and most importantly — the ability to scale without things falling through the cracks.</p><h2>Where to Start</h2><p>We build custom CRM systems tailored to Pakistani businesses — in Urdu if needed, with PKR support, and integrated with local payment gateways. Contact us to discuss your requirements.</p>',
                'meta_title' => 'Why Pakistani Businesses Need a CRM in 2026',
                'meta_description' => 'Pakistani SMEs lose clients and revenue by managing everything through WhatsApp and Excel. Here is why a CRM changes everything.',
                'status' => 'published',
            ],
        ];

        foreach ($posts as $postData) {
            $category = $createdCategories[$postData['category']] ?? null;
            $title = $postData['title'];

            BlogPost::firstOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'user_id' => $author?->id ?? 1,
                    'category_id' => $category?->id,
                    'title' => $title,
                    'excerpt' => $postData['excerpt'],
                    'content' => $postData['content'],
                    'status' => $postData['status'],
                    'published_at' => now()->subDays(rand(1, 60)),
                    'views_count' => rand(50, 800),
                    'meta_title' => $postData['meta_title'],
                    'meta_description' => $postData['meta_description'],
                ]
            );
        }

        // ── Portfolio Items ───────────────────────────────────────────────
        $portfolioItems = [
            [
                'title' => 'PakBazar Multi-Vendor E-Commerce',
                'client_name' => 'PakBazar Pvt. Ltd.',
                'category' => 'web',
                'short_desc' => 'Multi-vendor marketplace with 10K+ SKUs, seller onboarding, real-time inventory and Stripe payment integration.',
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'Redis'],
                'is_featured' => false,
                'display_order' => 1,
                'featured_image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=700&q=80&auto=format&fit=crop',
                'results' => ['10K+ products live in 8 weeks', '40% increase in seller sign-ups', 'Page load under 1.2s'],
            ],
            [
                'title' => 'RideFlow Ride-Hailing App',
                'client_name' => 'RideFlow Technologies',
                'category' => 'mobile',
                'short_desc' => 'Flutter ride-hailing app with live driver tracking, Firebase real-time updates and in-app wallet.',
                'tech_stack' => ['Flutter', 'Firebase', 'Google Maps', 'Laravel API'],
                'is_featured' => false,
                'display_order' => 2,
                'featured_image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=700&q=80&auto=format&fit=crop',
                'results' => ['Launched in 3 cities', '5,000 rides in first month', '4.8 star App Store rating'],
            ],
            [
                'title' => 'AI Client Onboarding Agent',
                'client_name' => 'Redis Solution (Internal)',
                'category' => 'ai',
                'short_desc' => 'Claude-powered AI agent that automates full client onboarding — from requirements to kickoff in under 12 minutes.',
                'tech_stack' => ['Claude API', 'n8n', 'Laravel', 'DocuSign API', 'Notion API'],
                'is_featured' => true,
                'display_order' => 0,
                'featured_image' => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=700&q=80&auto=format&fit=crop',
                'results' => ['Onboarding time: 6 hrs → 12 min', '34% increase in client satisfaction', '100% automated with human approval gate'],
            ],
            [
                'title' => 'TechManage Factory ERP',
                'client_name' => 'TechManage Industries',
                'category' => 'erp',
                'short_desc' => 'Complete factory ERP covering inventory management, HR & payroll, procurement and financial reporting.',
                'tech_stack' => ['Laravel', 'MySQL', 'Redis', 'Vue.js', 'ApexCharts'],
                'is_featured' => false,
                'display_order' => 3,
                'featured_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=700&q=80&auto=format&fit=crop',
                'results' => ['Replaced 7 Excel spreadsheets', '60% reduction in inventory errors', 'Real-time P&L dashboard'],
            ],
            [
                'title' => 'Meta Ads Campaign — Fashion Brand',
                'client_name' => 'Confidential',
                'category' => 'marketing',
                'short_desc' => '340% ROAS improvement over 90 days via creative testing, audience segmentation and conversion funnel optimisation.',
                'tech_stack' => ['Meta Ads', 'Google Analytics 4', 'Creative Design', 'A/B Testing'],
                'is_featured' => false,
                'display_order' => 4,
                'featured_image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=700&q=80&auto=format&fit=crop',
                'results' => ['ROAS: 1.2x → 3.8x in 90 days', '62% drop in cost per purchase', 'Revenue 3x MoM'],
            ],
            [
                'title' => 'MediBook Healthcare Appointment App',
                'client_name' => 'MediBook Clinics',
                'category' => 'mobile',
                'short_desc' => 'Patient appointment booking for a 12-clinic chain with real-time slot management and EMR integration.',
                'tech_stack' => ['Flutter', 'Firebase', 'REST API', 'Laravel'],
                'is_featured' => false,
                'display_order' => 5,
                'featured_image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=700&q=80&auto=format&fit=crop',
                'results' => ['12 clinics, 50K+ patients onboarded', 'No-show rate reduced by 28%', '4.7 Play Store rating'],
            ],
        ];

        foreach ($portfolioItems as $itemData) {
            PortfolioItem::firstOrCreate(
                ['slug' => Str::slug($itemData['title'])],
                array_merge($itemData, ['status' => 'active', 'description' => null, 'gallery_images' => null, 'project_url' => null])
            );
        }
    }
}
