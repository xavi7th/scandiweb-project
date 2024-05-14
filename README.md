# Scandiweb Junior Developer Test Project

This repository contains my solution to the [Scandiweb junior developer test](https://github.com/aleksis-ste/Scandiweb/blob/master/Home_EDU_task.pdf). The project demonstrates my skills and understanding of web development concepts, as well as my ability to solve problems and implement solutions using HTML, CSS, JavaScript, and other relevant technologies.

## Features

- **[Validation and Business Logic]**: The project aims to test implementation of validation and business logic.
- **[MVC]**: This project aims to test understanding of the implementations of MVC architecture.
- **[Framework restricetd]**: The project aims to test the understanding of underlying PHP principles without the prvisions of framework abstractions.

## Requirements

- The expected outcome is 2 separate pages for product list and product add
- Product list should list all existing products and details like
  - SKU (unique for each product)
  - Name
  - Price
- Each product also has a special attribute, which we expect you to be able to display as well based on type
  - size in MB (for DVD discs)
  - weight in KG for books
  - dimension in (WxHxL) for furniture
- Addition feature of mass delete action implemented as checkboxes close to each product.
- Product add page should display a form with the following fields
  - SKU
  - Name
  - Price
  - Type switcher (buttons for each type)
  - Special attribute (should be dynamically changed when a type is switched)
- Validate the input according to the type selected
- Full requirement [here](https://scandiweb.notion.site/Junior-Developer-Test-Task-1b2184e40dea47df840b7c0cc638e61e)

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP

## Getting Started

To run the project locally, follow these steps:

1. Clone this repository to your local machine.
2. Open the project directory in your terminal.
3. Run ```php -S localhost:3000``` in the project folder
4. View the project on the broswer at http://localhost:3000

## Demo

You can view a live demo of the project [here](#)

<!-- ## Screenshots

*(Add screenshots of the project to showcase its appearance and functionality)* -->

## Contributing

Contributions to this project are welcome! If you find any bugs or have suggestions for improvements, please feel free to open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
