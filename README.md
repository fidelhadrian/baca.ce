Setup Instructions 
1. Clone the Repository
    git clone https://github.com/baca.ce.git
    cd your-repository
2. Install Dependencies
    composer install
    npm install
3. Configure Environment
    - Copy `.env.example` to `.env`:
      cp .env.example .env
    - Update `.env` file with your database details.

4. Run Migrations and Seed Database
    php artisan migrate:fresh --seed

5. Compile Frontend Assets
    npm run dev

6. Start the Development Server
    php artisan serve

