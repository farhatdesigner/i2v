<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;

if (!defined('ABSPATH'))
  exit;

class Hotel_Security_Map extends Widget_Base
{
  public function get_name()
  {
    return 'hotel_security_map';
  }

  public function get_title()
  {
    return 'Hotel Security Intelligence Map';
  }

  public function get_icon()
  {
    return 'fa fa-map';
  }

  public function get_category()
  {
    return ['general'];
  }

  protected function register_controls()
  {
    // No controls - all static
  }

  protected function render()
  {
    ?>

    <style>
      /* Hotel Security Intelligence Map Widget Styles */
      .hotel-security-map-widget {
        width: 100%;
        background: #ffffff;
        border-radius: 8px;
      }

      .security-map-container {
        max-width: 1200px;
        margin: 0 auto;
      }

      /* Header Styles */
      .security-map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 12px 16px;
      }

      .map-title {
        margin: 0;
        color: #5F6F94;
        font-size: 16px;
        font-weight: 500;
        line-height: 24px;
      }

      .live-scanning-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 40px;
        border: 1px solid #E6EBF2;
        background: #F2F5FA;
        padding: 4px 12px;
      }

      .live-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
      }

      .live-dot.pulsing-red {
        background-color: #EF4444;
        animation: pulse-red 2s ease-in-out infinite;
      }

      @keyframes pulse-red {

        0%,
        100% {
          opacity: 1;
          transform: scale(1);
        }

        50% {
          opacity: 0.7;
          transform: scale(1.2);
        }
      }

      .live-text {
        color: #C92629;
        font-size: 14px;
        font-weight: 600;
        line-height: 20px;
        letter-spacing: 2.1px;
      }

      /* Floor Plan Grid */
      .floor-plan-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(4, 1fr);
        gap: 15px;
        min-height: 600px;
        margin-bottom: 30px;
      }

      .floor-area {
        border: 2px solid #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 15px;
        transition: all 0.3s ease;
      }

      .floor-area.empty-area {
        background: #ffffff;
        border-color: #e5e7eb;
      }

      .floor-area.guest-rooms {
        grid-column: 1 / 2;
        grid-row: 1 / 2;
      }

      .floor-area.lobby-reception {
        grid-column: 3 / 4;
        grid-row: 1 / 2;
      }

      .floor-area.main-lobby {
        grid-column: 2 / 4;
        grid-row: 2 / 3;
        background: #3b82f6;
        border-color: #3b82f6;
      }

      .floor-area.kitchen-dining {
        grid-column: 4 / 5;
        grid-row: 2 / 3;
        border-color: #fbbf24;
      }

      .floor-area.parking-corridors {
        grid-column: 1 / 2;
        grid-row: 3 / 4;
        border-color: #f59e0b;
      }

      .area-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        text-align: center;
      }

      .area-sub-label {
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 8px;
        text-align: center;
      }

      .area-label-large {
        font-size: 32px;
        font-weight: 700;
        color: #ffffff;
        text-align: center;
      }

      /* Status Indicators */
      .status-indicator {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
      }

      .status-icon {
        position: relative;
        z-index: 2;
        animation: blink-icon 2s ease-in-out infinite;
      }

      @keyframes blink-icon {

        0%,
        100% {
          opacity: 1;
        }

        50% {
          opacity: 0.6;
        }
      }

      .status-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        z-index: 1;
      }

      .ring-red {
        border: 3px solid #EF4444;
        animation: pulse-ring-red 2s ease-in-out infinite;
      }

      .ring-orange {
        border: 3px solid #F59E0B;
        animation: pulse-ring-orange 2s ease-in-out infinite;
      }

      .ring-green {
        border: 3px solid #10B981;
        animation: pulse-ring-green 2s ease-in-out infinite;
      }

      @keyframes pulse-ring-red {
        0% {
          transform: translate(-50%, -50%) scale(1);
          opacity: 1;
        }

        100% {
          transform: translate(-50%, -50%) scale(1.8);
          opacity: 0;
        }
      }

      @keyframes pulse-ring-orange {
        0% {
          transform: translate(-50%, -50%) scale(1);
          opacity: 1;
        }

        100% {
          transform: translate(-50%, -50%) scale(1.8);
          opacity: 0;
        }
      }

      @keyframes pulse-ring-green {
        0% {
          transform: translate(-50%, -50%) scale(1);
          opacity: 1;
        }

        100% {
          transform: translate(-50%, -50%) scale(1.8);
          opacity: 0;
        }
      }

      .status-text {
        font-size: 11px;
        font-weight: 500;
        color: #6b7280;
        text-align: center;
      }

      .status-threat .status-text {
        color: #EF4444;
      }

      .status-monitoring .status-text {
        color: #F59E0B;
      }

      .status-protected .status-text {
        color: #10B981;
      }

      /* Legend */

      .security-map-legend {
        display: flex;
        padding: var(--M, 12px) var(--L, 16px);
        justify-content: center;
        align-items: center;
        gap: var(--4XL, 32px);
        align-self: stretch;
      }

      .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
      }

      .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
      }

      .dot-red {
        background-color: #EF4444;
      }

      .dot-orange {
        background-color:#A65B00;
      }

      .dot-green {
        background-color: #418259;
      }

      .legend-text {
        color: #C92629;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        line-height: 142.857%;
      }
      .legend-text.monitoring {
        color: #A65B00;
      }
      .legend-text.protected {
        color: #418259;
      }

      /* Responsive Styles */
      @media (max-width: 768px) {
        .floor-plan-grid {
          grid-template-columns: repeat(2, 1fr);
          grid-template-rows: repeat(6, 1fr);
          min-height: 800px;
        }

        .floor-area.guest-rooms {
          grid-column: 1 / 2;
          grid-row: 1 / 2;
        }

        .floor-area.lobby-reception {
          grid-column: 2 / 3;
          grid-row: 1 / 2;
        }

        .floor-area.main-lobby {
          grid-column: 1 / 3;
          grid-row: 2 / 3;
        }

        .floor-area.kitchen-dining {
          grid-column: 1 / 2;
          grid-row: 3 / 4;
        }

        .floor-area.parking-corridors {
          grid-column: 2 / 3;
          grid-row: 3 / 4;
        }

        .security-map-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 15px;
        }

        .security-map-legend {
          flex-direction: column;
          gap: 15px;
          align-items: center;
        }
      }
    </style>

    <div class="hotel-security-map-widget">
      <div class="security-map-container">
        <!-- Header -->
        <div class="security-map-header">
          <div class="header-left">
            <h2 class="map-title"><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Vector-1.svg"
                alt="Vector"> Hotel Security Intelligence Map</h2>
          </div>
          <div class="header-right">
            <div class="live-scanning-indicator">
              <span class="live-dot pulsing-red"></span>
              <span class="live-text">LIVE SCANNING</span>
            </div>
          </div>
        </div>

        <!-- Floor Plan Grid -->
        <div class="floor-plan-grid">
          <!-- Guest Rooms - Protected (Green) -->
          <div class="floor-area guest-rooms">
            <div class="area-label">Guest Rooms</div>
            <div class="status-indicator status-protected">
              <div class="status-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="10" fill="#10B981" stroke="#10B981" stroke-width="2" />
                  <path d="M8 12L11 15L16 9" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
              <div class="status-ring ring-green"></div>
              <span class="status-text">Protected</span>
            </div>
          </div>

          <!-- Empty Area 1 -->
          <div class="floor-area empty-area"></div>

          <!-- Lobby & Reception - Active Threat (Red) -->
          <div class="floor-area lobby-reception">
            <div class="area-label">Lobby & Reception</div>
            <div class="status-indicator status-threat">
              <div class="status-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="10" fill="#EF4444" stroke="#EF4444" stroke-width="2" />
                  <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
              </div>
              <div class="status-ring ring-red"></div>
              <span class="status-text">Active threat</span>
            </div>
          </div>

          <!-- Empty Area 2 -->
          <div class="floor-area empty-area"></div>

          <!-- Main Lobby Area -->
          <div class="floor-area main-lobby">
            <div class="area-label-large">LOBBY</div>
          </div>

          <!-- Kitchen & Dining - Monitoring (Orange) -->
          <div class="floor-area kitchen-dining">
            <div class="area-label">Kitchen & Dining</div>
            <div class="area-sub-label">KITCHEN</div>
            <div class="status-indicator status-monitoring">
              <div class="status-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="10" fill="#F59E0B" stroke="#F59E0B" stroke-width="2" />
                  <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
              </div>
              <div class="status-ring ring-orange"></div>
              <span class="status-text">Monitoring</span>
            </div>
          </div>

          <!-- Empty Area 3 -->
          <div class="floor-area empty-area"></div>

          <!-- Empty Area 4 -->
          <div class="floor-area empty-area"></div>

          <!-- Parking & Corridors - Monitoring (Orange) -->
          <div class="floor-area parking-corridors">
            <div class="area-label">Parking & Corridors</div>
            <div class="area-sub-label">PARKING</div>
            <div class="status-indicator status-monitoring">
              <div class="status-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="12" cy="12" r="10" fill="#F59E0B" stroke="#F59E0B" stroke-width="2" />
                  <path d="M12 8V12M12 16H12.01" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
              </div>
              <div class="status-ring ring-orange"></div>
              <span class="status-text">Monitoring</span>
            </div>
          </div>

          <!-- Empty Area 5 -->
          <div class="floor-area empty-area"></div>

          <!-- Empty Area 6 -->
          <div class="floor-area empty-area"></div>
        </div>

        <div class="security-map-hotel">
          <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/plan-floor.svg" alt="Plan Floor">
        </div>

        <!-- Legend -->
        <div class="security-map-legend">
          <div class="legend-item">
            <span class="legend-dot dot-red"></span>
            <span class="legend-text">Active threat</span>
          </div>
          <div class="legend-item">
            <span class="legend-dot dot-orange"></span>
            <span class="legend-text monitoring">Monitoring</span>
          </div>
          <div class="legend-item">
            <span class="legend-dot dot-green"></span>
            <span class="legend-text protected">Protected</span>
          </div>
        </div>
      </div>
    </div>

    <?php
  }
}

