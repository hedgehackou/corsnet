import store from "@/store/index";

export default class StoreModule {
  static registerOne(moduleName: string, moduleObject: any) {
    // @ts-ignore
    if (!store.state[moduleName]) {
      store.registerModule(moduleName, moduleObject);
    }
  }
  static registerMany(moduleList: any) {
    if (
      typeof moduleList !== "object" ||
      moduleList === null ||
      Array.isArray(moduleList)
    ) {
      throw Error("Required Object.");
    }
    for (const [storeName, storeObject] of Object.entries(moduleList)) {
      this.registerOne(storeName, storeObject);
    }
  }
}
