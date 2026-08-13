# Statera | Economic Intelligence Dashboard
**A Longitudinal Study & Predictive Analytics Platform for Ghana’s Macro-Economy (2016 - 2026)**

> **Live Demo:** [http://statera.infinityfreeapp.com/]

##  Project Overview
Statera (Latin for *Balance*) is a high-end Fintech-inspired analytics dashboard designed to solve the problem of fragmented macro-economic data accessibility in Ghana. Built for researchers and economic students, it centralizes a decade of data across three core dimensions: **Inflation (CPI)**, **Currency Volatility (USD/GBP/EUR)**, and **GDP Growth**.

The platform moves beyond descriptive statistics by offering a heuristic "AI" insight engine and predictive modeling to project future economic trends.

##  Key Analytics Features

### 1. Longitudinal Data Visualization (Descriptive)
- **Decadal Scope:** Interactive time-series analysis spanning from 2016 to August 2026.
- **Dynamic Context:** Factual historical narratives for every fiscal year, explaining events like the 2016 "Dumsor" energy crisis, the 2018 Banking Cleanup, and the 2022 Hyper-inflation peak.
- **Interactive KPI Cards:** Month-on-month comparison with trend indicators (Increase/Decrease).

### 2. Predictive Intelligence (Forecasting)
- **Trend Extrapolation:** Utilizes linear regression logic to project T+1 monthly figures for Inflation and Exchange Rates.
- **Model Transparency:** Provides reasoning cards explaining Statistical Extrapolation, Correlational Lag, and Historical Variance.

### 3. "Statie" AI Insight Engine
- A heuristic-driven persona that "reads" the selected year's data and generates a detailed factual summary, helping users understand the *story* behind the numbers.

### 4. The Data Vault
- An aggregated annual repository that calculates decadal averages and fiscal resistance levels, offering a "one-stop-shop" for annualized economic records.

## 🛠 Technical Stack
- **Backend:** PHP 8.x (Object-Oriented Logic)
- **Database:** MySQL (Relational Time-Series Data)
- **Frontend:** Tailwind CSS (Modern Fintech UI), Chart.js (Data Visualization)
- **API Integration:** Real-time currency exchange rates (ExchangeRate-API)
- **Icons:** Lucide-React Icons

##  Business Analytics Relevance
This project demonstrates a core competency in the end-to-end data lifecycle:
- **Data Engineering:** Designing a relational schema to handle 10+ years of monthly economic indicators.
- **ETL:** Processing raw economic data and transforming it into interactive visualizations.
- **Predictive Modeling:** Implementing time-series forecasting to assist in proactive decision-making.
- **UI/UX Design:** Applying Fintech aesthetic principles (Glassmorphism, Responsive Design) to complex data.

##  Installation & Setup
1. Clone the repository: `git clone https://github.com/yourusername/statera.git`
2. Import the SQL file located in `/sql/statera.sql` into your local MySQL environment.
3. Update `db.php` with your local credentials.
4. Obtain a free API key from [ExchangeRate-API](https://www.exchangerate-api.com/) and update `logic.php`.

##  Researcher’s Note
Statera was born out of a personal challenge faced during undergraduate studies: the difficulty of gathering centralized, clean, monthly macro-economic data for Ghana. This tool serves as an Open Educational Resource (OER) for future students.
