# Invoicing and Garage Management Application

This is a Laravel-based web application for managing invoices and vehicles for a garage. The app helps to track customers, vehicles, vehicle histories, and invoices with features like partial payments, VAT calculation, and more.

## Features

-   **Vehicle Management**: Add, edit, and manage vehicles with details like brand, model, year, type, color, and license plate.
-   **Vehicle History Tracking**: Keep track of service history for each vehicle.
-   **Customer Management**: Manage customers' information, including company details, tax information, and contact information.
-   **Invoice Management**: Create, edit, and manage invoices for services rendered.
    -   Track `invoice items`, `payment history`, and `balance due`.
    -   **Status-based invoicing** (unpaid, partially paid, paid).
    -   **VAT Calculation**: Supports VAT calculation on the total invoice amount.
-   **Payment History**: View and manage payment history for each invoice, with the option to add partial payments.
-   **Dashboard**: A dashboard that shows analytics for total invoices, unpaid invoices, total balance due, and total payments made in the current month.
-   **Profile Management**: Update profile information including company details such as ICE, ID Fiscale, and more.

## Technologies

-   **Backend**: Laravel (PHP Framework)
-   **Frontend**: Tailwind CSS, Blade templates, Livewire for dynamic form handling
-   **Database**: MySQL or SQLite (Configurable)
-   **Authentication**: Laravel Jetstream (with profile photo management)

## Requirements

-   PHP >= 8.0
-   MySQL or SQLite
-   Composer
-   Node.js & npm (for frontend assets and Tailwind CSS)

## Installation

1. **Clone the repository**:

    ```bash
    git clone https://github.com/SakoDev/GarageManagement.git
    cd GarageManagement
    ```

2. **Install dependencies**:

    ```bash
    composer install
    npm install
    ```

3. **Create a `.env` file**:

    Copy the example `.env` file:

    ```bash
    cp .env.example .env
    ```

4. **Set up your environment**:

    Open the `.env` file and configure your database and other environment settings.

    ```bash
    APP_NAME="Invoicing and Garage Management"
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

5. **Generate the application key**:

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations**:

    ```bash
    php artisan migrate
    ```

7. **Compile frontend assets**:

    ```bash
    npm run dev
    ```

8. **Start the local development server**:

    ```bash
    php artisan serve
    ```

    The app will be available at `http://127.0.0.1:8000`.

## Usage

### Managing Vehicles

-   Navigate to the **Vehicles** section to add new vehicles.
-   Each vehicle is associated with a customer and can have multiple service histories.

### Invoices and Payments

-   Invoices can be created for services provided to customers.
-   Items can be added to each invoice with a type, description, quantity, and unit price.
-   VAT is calculated automatically based on the total invoice amount.
-   Invoices can be marked as `unpaid`, `partially paid`, or `paid`.
-   Payments can be recorded, and the balance due is updated accordingly.

### Profile Management

-   Users can update their profile information, including company details such as ICE, company name, address, and tax details.
-   Profile photo management is available using Laravel Jetstream.

## Dashboard

The dashboard provides an overview of the application's key metrics:

-   **Total Invoices**: Shows the total number of invoices created.
-   **Unpaid Invoices**: Displays the count of unpaid invoices.
-   **Total Balance Due**: Shows the total amount owed by customers across all unpaid and partially paid invoices.
-   **Total Payments This Month**: Shows the sum of all payments received in the current month.

## Customization

### Configuring VAT

You can set the VAT rate in the invoice creation form. The VAT is automatically calculated based on the total invoice amount.

### Payment Methods

Payments can be recorded with different methods, such as cash, credit card, or bank transfer. The balance due is automatically updated when a payment is recorded.

## Deployment

To deploy the application, follow these steps:

1. **Set up the server**: Ensure that your server meets the [Laravel server requirements](https://laravel.com/docs/8.x/deployment#server-requirements).
2. **Clone the repository** to your server.
3. **Install dependencies** on the server.
4. **Run migrations** on the production database.
5. **Set up the environment variables** in the `.env` file.
6. **Run `php artisan optimize`** to cache configurations.

## Testing

To run the application's test suite:

```bash
php artisan test
```

## Contributing

Feel free to submit pull requests or create issues to improve the application. Contributions are welcome!

## Contact

If you encounter any issues, need support, or would like updates, feel free to contact me:

- **GitHub Issues**: [Open an issue](https://github.com/SakoDev/GarageManagement.git/issues)

## License

This project is open-source and available under the [MIT License](LICENSE).

