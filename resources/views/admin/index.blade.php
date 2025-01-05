@extends('layout.admin-layout')

@section('main')



    

<div class="w-full px-2 py-2">
    <div class="mb-4 flex flex-col justify-between gap-8 md:flex-row md:items-center">
      <div class="flex w-full shrink-0 gap-2 md:w-max">
        <div class="w-full md:w-72">
          <div class="relative w-full">
            <input placeholder="Search" type="text" class="w-full aria-disabled:cursor-not-allowed outline-none focus:outline-none text-stone-800 dark:text-white placeholder:text-stone-600/60 ring-transparent border border-stone-200 transition-all ease-in disabled:opacity-50 disabled:pointer-events-none select-none text-sm py-2 px-2.5 ring shadow-sm bg-white rounded-lg duration-100 hover:border-stone-300 hover:ring-none focus:border-stone-400 focus:ring-none peer" />
            
          </div>
        </div>

      </div>
    </div>
    <div class="w-full overflow-hidden rounded-lg border border-stone-200">
      <table class="w-full text-left">
        <thead class="border-b border-stone-200 bg-gray-100 text-sm font-medium text-stone-600 dark:bg-surface-dark">
          <tr>
            <th class="px-2.5 py-2 text-start font-medium">Invoice No</th>
            <th class="px-2.5 py-2 text-start font-medium">Amount</th>
            <th class="px-2.5 py-2 text-start font-medium">Date</th>
            <th class="px-2.5 py-2 text-start font-medium">Status</th>
            <th class="px-2.5 py-2 text-start font-medium">Paid By</th>
            <th class="px-2.5 py-2 text-start font-medium"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="p-4 border-b border-surface-light">
              <div class="flex items-center gap-2">
                    INV0001
              </div>
            </td>
            <td class="p-4 border-b border-surface-light">
              <small class="font-sans antialiased text-sm text-current">$2,500</small>
            </td>
            <td class="p-4 border-b border-surface-light">
              <small class="font-sans antialiased text-sm text-current">Wed 3:00pm</small>
            </td>
            <td class="p-4 border-b border-surface-light">
              <div class="w-max">
                <div class="relative inline-flex w-max items-center border font-sans font-medium rounded-md text-xs p-0.5 bg-green-500/10 border-transparent text-green-500 shadow-none">
                  <span class="font-sans text-current leading-none my-0.5 mx-1.5">paid</span>
                </div>
              </div>
            </td>
            <td class="p-4 border-b border-surface-light">
              <div class="flex items-center gap-3">
                BCA QRIS
              </div>
            </td>
            <td class="p-4 border-b border-surface-light">
              <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none outline-none group"><svg width="1.5em" height="1.5em" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-4 w-4"><path d="M14.3632 5.65156L15.8431 4.17157C16.6242 3.39052 17.8905 3.39052 18.6716 4.17157L20.0858 5.58579C20.8668 6.36683 20.8668 7.63316 20.0858 8.41421L18.6058 9.8942M14.3632 5.65156L4.74749 15.2672C4.41542 15.5993 4.21079 16.0376 4.16947 16.5054L3.92738 19.2459C3.87261 19.8659 4.39148 20.3848 5.0115 20.33L7.75191 20.0879C8.21972 20.0466 8.65806 19.8419 8.99013 19.5099L18.6058 9.8942M14.3632 5.65156L18.6058 9.8942" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></svg>
              </button>
            </td>
          </tr>
          <tr>
            <td class="p-4 border-b border-surface-light">
              <div class="flex items-center gap-3">
                INV0002
              </div>
            </td>
            <td class="p-4 border-b border-surface-light">
              <small class="font-sans antialiased text-sm text-current">$5,000</small>
            </td>
            <td class="p-4 border-b border-surface-light">
              <small class="font-sans antialiased text-sm text-current">Wed 1:00pm</small>
            </td>
            <td class="p-4 border-b border-surface-light">
              <div class="w-max">
                <div class="relative inline-flex w-max items-center border font-sans font-medium rounded-md text-xs p-0.5 bg-green-500/10 border-transparent text-green-500 shadow-none">
                  <span class="font-sans text-current leading-none my-0.5 mx-1.5">paid</span>
                </div>
              </div>
            </td>
            <td class="p-4 border-b border-surface-light">
              <div class="flex items-center gap-3">
                SHOPPEPAY
              </div>
            </td>
            <td class="p-4 border-b border-surface-light">
              <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[38px] min-h-[38px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none outline-none group"><svg width="1.5em" height="1.5em" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-4 w-4"><path d="M14.3632 5.65156L15.8431 4.17157C16.6242 3.39052 17.8905 3.39052 18.6716 4.17157L20.0858 5.58579C20.8668 6.36683 20.8668 7.63316 20.0858 8.41421L18.6058 9.8942M14.3632 5.65156L4.74749 15.2672C4.41542 15.5993 4.21079 16.0376 4.16947 16.5054L3.92738 19.2459C3.87261 19.8659 4.39148 20.3848 5.0115 20.33L7.75191 20.0879C8.21972 20.0466 8.65806 19.8419 8.99013 19.5099L18.6058 9.8942M14.3632 5.65156L18.6058 9.8942" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path></svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="flex items-center justify-between border-t border-surface-light py-4">
      <button class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed focus:shadow-none text-sm py-1.5 px-3 shadow-sm bg-transparent relative text-stone-700 hover:text-stone-700 border-stone-300 hover:bg-transparent duration-150 hover:border-stone-600 rounded-lg hover:opacity-60 hover:shadow-none">Previous</button>
      <div class="flex items-center gap-2">
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md shadow-sm hover:shadow bg-stone-200 border-stone-200 text-stone-800 hover:bg-stone-100 hover:bg-stone-100">1</button>
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none">2</button>
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none">3</button>
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none">...</button>
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none">8</button>
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none">9</button>
        <button class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-stone-800 hover:bg-stone-200/10 hover:border-stone-600/10 shadow-none hover:shadow-none">10</button>
      </div>
      <button class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed focus:shadow-none text-sm py-1.5 px-3 shadow-sm bg-transparent relative text-stone-700 hover:text-stone-700 border-stone-300 hover:bg-transparent duration-150 hover:border-stone-600 rounded-lg hover:opacity-60 hover:shadow-none">Next</button>
    </div>
  </div>
  

@endsection