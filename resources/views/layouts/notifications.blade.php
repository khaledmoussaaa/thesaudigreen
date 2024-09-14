  <!-- Notificaion Container -->
  <div class="notificaionContainer">
      <div class="notificaionHead">
          <div class="row details">
              <h3 class="row">{{__('translate.notifications')}}
                  @if(Auth::user()->usertype != 'Customer')
                  (<livewire:common.counts :status="'null'" :count="'notificationsAdmin'" />)
                  @else
                  (<livewire:common.counts :status="'null'" :count="'notificationsCustomer'" />)
                  @endif
              </h3>
          </div>
          <i id="close" class="bi bi-x-circle pointer"></i>
      </div>
      @if(Auth::user()->usertype != 'Customer')
      <livewire:common.notifications :type="'Admin'" />
      @else
      <livewire:common.notifications :type="'Customer'" />
      @endif
  </div>