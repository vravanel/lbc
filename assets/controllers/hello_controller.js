import { Controller } from "@hotwired/stimulus"

import.meta.stimulusFetch = "eager";
import.meta.stimulusIdentifier = "test";

export default class extends Controller {
    static targets = [ "name", "output" ]
  
    greet() {
      const element = this.nameTarget
      const name = element.value
      this.outputTarget.textContent = `Hello, ${name}!`
      console.log(`Hello, ${name}!`)
    }
  }