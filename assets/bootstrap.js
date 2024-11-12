import { startStimulusApp, registerControllers } from "vite-plugin-symfony/stimulus/helpers";
//import LiveComponent from "@symfony/ux-live-component";

const app = startStimulusApp();
registerControllers(
    app,
    import.meta.glob('./controllers/*_controller.js', {
        query: "?stimulus",
        /**
         * always true, the `lazy` behavior is managed internally with
         * import.meta.stimulusFetch (see reference)
         */
        eager: true,
    }),
    import.meta.glob([
        './images/**'
    ])
);

//app.register("live", LiveComponent);